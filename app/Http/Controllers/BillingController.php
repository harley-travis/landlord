<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillingController extends Controller {
    
    public function index() {

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = User::find(Auth::user()->id);

        $customer = \Stripe\Customer::retrieve($user->stripe_id);

        $bank_accounts = \Stripe\Customer::allSources(
            $user->stripe_id,
            [
              'limit' => 3,
              'object' => 'bank_account',
            ]
          );

        return view('settings.billing.index', [
            'bank_accounts' => $bank_accounts, 
            'customer' => $customer, 
        ]);

    }

    public function getTrialView() {
        return view('settings.billing.trial.end');
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


        return view('settings.billing.index', [

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
        return view('settings.billing.ach.create');
    }

    public function storeACH(Request $request) {

        /**
         * NEED TO SETUP LOGIC TO SEE IF THEY HAVE A STRIPE ACCOUNT
         * IF NOT BUILD ONE. 
         * DON'T WANT TO HANDLE THAT AT THE REGISTER PAGE
         * 
         * WAIT WHAT ABOUT THE TWO WEEK TRIAL???
         * THEN I MIGHT HAVE TO HANDLE THAT AT THE REGISTRATION 
         * 
         * OR CREATE A FORM THAT WHEN THEY CREATE THEIR ACCOUNT, IMMEIDALTY THEY HAVE
         * TO ADD THEIR BILLING INFORMATION?
         * 
         * OR A FORM THAT JUST CREATES A TRIAL PERIOD. IT WOULD CREATE A CUSTOMER IN STIRPE
         * THEY WOULDN'T HAVE TO PUT IN ANY INFOMRATION
         * 
         * AND IT WOULD CANCEL AT 2 WEEK OR PRESENT THEM WITH A FORM TO ADD THEIR BILLING 
         * INFORMATION
         */
 
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

        // if the user is not a tenant create a subscription
        if( $user->product > 1 ) { 
            $this->createOwnerSubscription();
        } else {
            createTenantSubscription();
        }

        return redirect()
            ->route('settings.billing.index', [
                'bank_accounts' => $bank_accounts, 
                'customer' => $customer, 
            ])->with('info', 'Your account was successfully added. Check your account in 1-2 business days to see 2 small deposits. Verify you account by entering in those deposit amounts. Deposits take 1-3 business days.');

    }

    public function verifyACH($id) {
        return view('settings.billing.ach.verify', ['id' => $id]);
    }

    public function storeVerifyACH(Request $request) {

        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $customer = \Stripe\Customer::retrieve($user->stripe_id);

        // get the existing bank account
        $bank_account = \Stripe\Customer::retrieveSource(
            $user->stripe_id,
            $request->input('id')
        );

        if( $bank_account->status === "verified" ) {

            return redirect()
                    ->back()
                    ->with('info', 'This account has already been verified.');

        } else {
             
            // verify the account
            $bank_account->verify([
                'amounts' => [
                    $request->input('value1') * 100, 
                    $request->input('value2') * 100,
                ]
            ]);
       
            $bank_accounts = \Stripe\Customer::allSources(
                $user->stripe_id,
                [
                    'limit' => 3,
                    'object' => 'bank_account',
                ]
            );

            return redirect()
                ->route('settings.billing.index', [
                    'bank_accounts' => $bank_accounts, 
                    'customer' => $customer, 
                ])->with('info', 'Your account was successfully verified.');

        }
            
    }

    public function destroyACH($id) {

        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $customer = \Stripe\Customer::retrieve($user->stripe_id);

        $bank_accounts = \Stripe\Customer::allSources(
            $user->stripe_id,
            [
                'limit' => 3,
                'object' => 'bank_account',
            ]
        );

        if( count($bank_accounts->data) <= 1 ) { 

            return redirect()
            ->route('settings.billing.index', [
                'bank_accounts' => $bank_accounts, 
                'customer' => $customer, 
            ])->with('danger', 'You are not able to remove an ACH account if there is no other account on file. Please add an ACH account then remove this account after. If you have any problems, please contact support for help');

        } else {

            \Stripe\Customer::deleteSource(
                $user->stripe_id,
                $id
            );

            return redirect()
            ->route('settings.billing.index', [
                'bank_accounts' => $bank_accounts, 
                'customer' => $customer, 
            ])->with('info', 'Your account was successfully deleted.');

        }

    }

    /**
     * allow the home owner to enroll in autopay
     * be sure to clairfy that the payment will auto increase
     * if they add a new proprty
     */
    public function createOwnerSubscription() {

        /**
         * every time i delete or add a new account
         * it creates another subscription for me. 
         * need to figure out how to prevent adding more subscriptions 
         * so the user isn't charged mulitple times
         */

        /**
         * DO I NEED TO CREATE A SINGLE PRODUCT AND ATTACH PLANS TO THAT?
         * NAME THE PLAN'S AFTER THE CUSTOMERS NAME
         */

        /**
         * need to figure out how metered works. does it check every pay period? and then 
         * charge? 
         * does it charge based on unit price?
         */
        
        /**
         * Does the trial period work, and does it apply every month?
         */

        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $base = 1500;
        $additionalProperties = 200;
        $freeUnits = 5;
        $usage = $this->calculateUsage();
        $amount = '';

        if( $usage <= $freeUnits ) {
            $amount = $base;
        } else {
            $amount = ( $usage - $freeUnits ) * $additionalProperties + $base;
        }

        // $product = \Stripe\Product::create([
        //     'name' => 'Monthly Home Owner Service',
        //     'type' => 'service',
        // ]);

        $plan = \Stripe\Plan::create([
            "nickname" => $user->name ." Home Owner Metered Monthly",
            "product" => "prod_G7cAszLu1IUcgA", // hard coded. i think i just need one of these
            "amount" => $amount,
            "currency" => "usd",
            "interval" => "month",
            "usage_type" => "metered",
            "trial_period_days" => 14,
        ]);

        $subscription = \Stripe\Subscription::create([
            "customer" => $user->stripe_id,
            "items" => [
                [
                    "plan" => $plan->id,
                ],
            ],
        ]);

    }

    public function calculateUsage() {

        $user = User::find(Auth::user()->id);
        $amount = DB::table('company_tenant')->where('company_id', '=', $user->company_id)->count();

        return $amount;

    }

}
