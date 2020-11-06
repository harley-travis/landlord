<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Company;
use App\Rent;
use App\Tenant;
use App\Transaction;
use App\SetupPayment;
use Carbon\Carbon;
use App\Mail\PaymentConfirmation;
use App\Mail\PaymentFailed;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController {

    // listen for when a connect account has been created
    // then update the Connect Account User's Customer info
    public function handleAccountUpdated($payload) {

        // grab the users information
        $email = $payload['data']['object']['individual']['email'];

        $account_holder_name = $payload['data']['object']['external_accounts']['data']['account_holder_name'];
        $routing_number = $payload['data']['object']['external_accounts']['data']['routing_number'];
        $account_number = $payload['data']['object']['external_accounts']['data']['account_number']; // this is a prob. i don't get this data
        $account_holder_type = $payload['data']['object']['external_accounts']['data']['account_holder_type'];
        

        // find their Stripe Customer infomration
        $user = User::where('email', '=', $email)->first();

        // update their stripe information
        $bank_account = \Stripe\Customer::createSource(
            $user->stripe_id,
          [
            'bank_account' => [
                'account_holder_name' => $account_holder_name,
                'routing_number' => $routing_number,
                'account_number' => $account_number,
                'account_holder_type' => $account_holder_type,
                'country' => 'US',
                'currency' => 'usd',     
            ],
          ]
        );

        // need to figure out when they do the onboarding process if their account is verified immedialty. 

        // subscribe them to the account plan

    }
    
    public function handleChargeFailed($payload) {

        // update transaction table to indicat that the balance has not been paid in full
        $confirmationNumber = $payload['data']['object']['metadata']['ConfirmationNumber'];
        $transaction = Transaction::where('confirmation', '=', $confirmationNumber )->first();
        $transaction->paid_in_full = 0;
        $transaction->payment_failed = 1;
        $transaction->save();

        // inform the tenant
        $stripe_id = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', '=', $stripe_id)->first();
        $email = $user->email;
        $total = $payload['data']['object']['amount'];

        Mail::to($email)->send(new PaymentFailed($user, $total));

        return new Response('received', 200);

    }

    public function handleChargeSucceeded($payload) {

        $stripe_id = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', '=', $stripe_id)->first();
        $email = $user->email;
        $total = $payload['data']['object']['amount'];

        // update transaction table to indicat that the balance has not been paid in full
        $confirmationNumber = $payload['data']['object']['metadata']['ConfirmationNumber'];
        $transaction = Transaction::where('confirmation', '=', $confirmationNumber )->first();
        $transaction->paid_in_full = 1;
        $transaction->save();

        // update the rent table
        $startDate = Carbon::now();
        $firstDay = $startDate->firstOfMonth();

        $tenant = Tenant::where('user_id', '=', $user->id)->first();
        $rent = Rent::where('property_id', '=', $tenant->property_id)->first();
        $rent->last_date_paid = Carbon::now();
        $rent->next_due_date = $firstDay;
        $rent->save();

        Mail::to($email)->send(new PaymentConfirmation($user, $total, $transaction->created_at, $confirmationNumber));

        return new Response('received', 200);

    }

    // calculate usage for landlord subscription
    public function calculateUsage($user) {
        
        /**
         * I DON'T NEED THIS BECUASE IF IM UPDATING EACH TABLE AFTER A NEW PROPERTY IS ADDED, 
         * OR IF RENT IS CHANGED, THEN IT SHOULD BE UPDATED ON THE PAYMENT TABLE.
         */

        
    }

    // get the data for upcoming subscriptions
    public function handleInvoiceUpcoming($payload) {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $customer = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', '=', $stripe_id)->first();
        $paymentSetup = SetupPayment::where('company_id', '=', $user->company_id)->first();
        $amount = $paymentSetup->pricingAmount;

        // set the subscurition amount this month with the stripe method
        \Stripe\Invoices::upcoming([
            'customer' => 'cus_IKt8UPXrRcD9uv',
            'total' => $amount,
        ]);

    }

}
