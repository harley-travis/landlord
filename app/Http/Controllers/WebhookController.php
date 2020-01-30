<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Rent;
use App\Tenant;
use App\Transaction;
use Carbon\Carbon;
use App\Mail\PaymentConfirmation;
use App\Mail\PaymentFailed;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController {
    
    public function handleChargeFailed($payload) {

        // update transaction table to indicat that the balance has not been paid in full
        $confirmationNumber = $payload['data']['object']['metadata']['ConfirmationNumber'];
        // $transaction = Transaction::where('confirmation', '=', $confirmationNumber )->first();
        // $transaction->paid_in_full = 0;
        // $transaction->save();

        // // inform the tenant
        // $stripe_id = $payload['data']['object']['customer'];
        // $user = User::where('stripe_id', '=', $stripe_id)->first();
        // $email = $user->email;
        // $total = $payload['data']['object']['amount'];

        // Mail::to($email)->send(new PaymentFailed($user, $total));

        return new Response('received', 200);

    }

    public function handleChargeSucceeded($payload) {

        $stripe_id = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', '=', $stripe_id)->first();
        $email = $user->email;
        $total = $payload['data']['object']['amount'];

        // update transaction table to indicat that the balance has not been paid in full
        $transaction = Transaction::where('confirmation', '=', $payload['data']['object']['ConfirmationNumber'])->first();
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

        Mail::to($email)->send(new PaymentConfirmation($user, $total));

        return new Response('received', 200);

    }

}
