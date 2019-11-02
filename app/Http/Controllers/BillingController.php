<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class BillingController extends Controller {
    
    public function index() {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = User::find(Auth::user()->id);
        $paymentMethods = $user->paymentMethods();

        $customer = \Stripe\Customer::retrieve($user->stripe_id);

        $bank_accounts = \Stripe\Customer::allSources(
            $user->stripe_id,
            [
              'limit' => 3,
              'object' => 'bank_account',
            ]
          );

        return view('settings.billing.index', [
            'paymentMethods' => $paymentMethods,
            'bank_accounts' => $bank_accounts, 
            'customer' => $customer, 
        ]);

    }

    public function create() {

        $user = User::find(Auth::user()->id);

        return view('settings.billing.create', [
            'intent' => $user->createSetupIntent()
        ]);

    }

    public function store(Request $request) {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = User::find(Auth::user()->id);

        // $payment_method = \Stripe\PaymentMethod::retrieve($intent->payment_method);
        // $payment_method->attach(['customer' => $user->stripe_id]);

        $card = \Stripe\Customer::createSource(
            $user->stripe_id,
            [
              'source' => 'tok_amex',
              'object' => 'card',

            ]
          );

        //$user->addPaymentMethod($card);

        $paymentMethods = $user->paymentMethods();

        return view('settings.billing.index', [
            'paymentMethods' => $paymentMethods,
        ]);     

    }


    /**
     * Property owners monthly payment fee to SenRent
     */
    public function singleOwnerCharge() {

        /**
         * before I charge the card i must figure out how to work the intent. 
         * you only need to get the intet once???
         * 
         * NEED TO DECLARE THEY PAYMENT METHOD!
         */

        $user = User::find(Auth::user()->id);

        $paymentMethod = $user->paymentMethod();
        
        $numberOfProperties = DB::table('company_tenant')->where('company_id', '=', $user->company_id)->count();

        if( $user->product === 1 ) {

            $base = 1500; // $15
            $freeProperties = 5; // 5 free properties
            $amountPerProperty = 200; // $2
            $sum = ( $numberOfProperties - $freeProperties * $amountPerProperty ) + $base * 100;
            $taxAmount = .12; // 12% NEED TO TALK TO MOORE ABOUT THIS. I THINK I NEED AN ARRAY TO PULL FROM TO CHARGE
            $total = ( $sum * $taxAmount ) + $sum;

            try {

                $payment = $user->charge($total, $paymentMethod, [
                    'custom_option' => $total,
                ]);

                return redirect()
                        ->route('billing.index')
                        ->with('info', 'We have successfully charged your account. The payment will take 3-5 business days to process.');
            
            } catch (Exception $e) {
                
                return redirect()
                        ->route('billing.index')
                        ->with('danger', 'There was an error processing your payment. Please try again, or contact customer support');
    
            }
            
        } else if( $user->product === 2 ) {

            $base = 1500; // $15
            $freeProperties = 5; // 5 free properties
            $amountPerProperty = 200; // $2
            $sum = ( $numberOfProperties - $freeProperties * $amountPerProperty ) + $base * 100;
            $taxAmount = .12; // 12% NEED TO TALK TO MOORE ABOUT THIS. I THINK I NEED AN ARRAY TO PULL FROM TO CHARGE
            $total = ( $sum * $taxAmount ) + $sum;

            try {

                $payment = $user->charge($total, $paymentMethod, [
                    'custom_option' => $total,
                ]);

                return redirect()
                        ->route('billing.index')
                        ->with('info', 'We have successfully charged your account. The payment will take 3-5 business days to process.');
    
            } catch (Exception $e) {
                
                return redirect()
                        ->route('billing.index')
                        ->with('danger', 'There was an error processing your payment. Please try again, or contact customer support');
    
            }

        } else if( $user->product === 3 ) {

            $base = 1500; // $15
            $freeProperties = 5; // 5 free properties
            $amountPerProperty = 200; // $2
            $sum = ( $numberOfProperties - $freeProperties * $amountPerProperty ) + $base * 100;
            $taxAmount = .12; // 12% NEED TO TALK TO MOORE ABOUT THIS. I THINK I NEED AN ARRAY TO PULL FROM TO CHARGE
            $total = ( $sum * $taxAmount ) + $sum;

            try {

                $payment = $user->charge($total, $paymentMethod, [
                    'custom_option' => $total,
                ]);

                return redirect()
                        ->route('billing.index')
                        ->with('info', 'We have successfully charged your account. The payment will take 3-5 business days to process.');
    
            } catch (Exception $e) {
                
                return redirect()
                        ->route('billing.index')
                        ->with('danger', 'There was an error processing your payment. Please try again, or contact customer support');
    
            }

        }

    }

    public function singleTenantCharge() {

    }

    /**
     * allow the home owner to enroll in autopay
     * be sure to clairfy that the payment will auto increase
     * if they add a new proprty
     */
    public function createOwnerSubscription() {

    }

    /**
     * allow the tenant to enroll in autopay
     */
    public function createTenantSubscription() {

    }

    public function taxPercentage() {
        /**
         * This function can only work on subscriptions 
         */
        return 20;
    }
    
    public function createACH() {
        return view('settings.billing.createACH');
    }

    public function storeACH(Request $request) {

        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $token = $request->request->get('stripeToken');

        $bank_account = \Stripe\Customer::createSource(
            $user->stripe_id,
          [
            'bank_account' => [
                'account_holder_name' => $request->input('account_holder_name'),
                'routing_number' => $request->input('routing_number'),
                'account_number' => $request->input('account_number'),
                'account_holder_type' => $request->input('account_holder_type'),
                'country' => 'US',
                'currency' => 'usd',     
            ],
          ]
        );

        $customer = \Stripe\Customer::retrieve($user->stripe_id);

         $bank_accounts = \Stripe\Customer::allSources(
            $user->stripe_id,
            [
              'limit' => 3,
              'object' => 'bank_account',
            ]
          );

          /**
           * need to return a view that says 'verify account'
           */

        return view('settings.billing.index', [
            'paymentMethods' => $paymentMethods,
            'bank_accounts' => $bank_accounts, 
            'customer' => $customer, 
        ]);

    }

    public function verifyACH() {

        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // get the existing bank account
        $bank_account = \Stripe\Customer::retrieveSource(
            $user->stripe_id,
            'ba_17SHwa2eZvKYlo2CUx7nphbZ'
        );
        
        // verify the account
        $bank_account->verify([
            'amounts' => [
                32, 
                45
            ]]);

    }

    public function chargeACH() {
        
        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $charge = \Stripe\Charge::create([
            'amount' => 1500,
            'currency' => 'usd',
            'customer' => $user->stripe_id,
        ]);   
    }

}
