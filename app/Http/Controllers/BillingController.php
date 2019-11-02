<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class BillingController extends Controller {
    
    public function index() {

        /**
         * Retrieve the biling history for the user
         * billing methods
         */

        $user = User::find(Auth::user()->id);
        $paymentMethods = $user->paymentMethods();

        return view('settings.billing.index', [
            'paymentMethods' => $paymentMethods,
        ]);

    }

    public function create() {

        /**
         * In order to add payment method, you need to declare your intent for security purposes. 
         * This goes for adding and modifying any payment information
         * 
         * https://laravel.com/docs/5.8/billing "Payment Methods for Subscriptions"
         * 
         */

         /**
         * 
         * 
         * NOTE!!!!! THIS IS WHERE I LEFT OFF   
         * 
         * Look at the instructions by laravel. it looks like their process is correct
         * and stripe gives you the "what to do on success"
         * the fuction to store the card via their api
         * 
         * https://stripe.com/docs/payments/cards/saving-cards-without-payment
         * 
         * step 5. custopmer::create or attach a paymentmethod
         * 
         * after you do that, then you want to pass the intent to the $user->addPaymentMethod($paymentMethod);
         * 
         * https://laravel.com/docs/5.8/billing#adding-payment-methods
         * 
         * i think this works for both ACH and cc. but I could be wrong. it's probably just for cards
         */

        $user = User::find(Auth::user()->id);

        return view('settings.billing.create', [
            'intent' => $user->createSetupIntent()
        ]);

    }

    public function store(Request $request) {

        $user = User::find(Auth::user()->id);

        dd('oh hi mark');

        // dd($user);


        // if( $user->stripe_id === null || $user->stripe_id === '' ) {

        //     // new customer
        //     \Stripe\Customer::create([
        //         'payment_method' => $intent->payment_method,
        //     ]);

        //     $user->addPaymentMethod($paymentMethod);

        // } else {

        //     dd($intent->payment_method);

        //     // existing customer
        //     $payment_method = \Stripe\PaymentMethod::retrieve($intent->payment_method);
        //     $payment_method->attach(['customer' => $user->stripe_id]);

        //     $user->addPaymentMethod($paymentMethod);

        // }

        // $paymentMethods = $user->paymentMethods();

        // return view('settings.billing.index', [
        //     'paymentMethods' => $paymentMethods,
        // ]);     

    }

    public function edit() {

        /**
         * In order to add payment method, you need to declare your intent for security purposes. 
         * This goes for adding and modifying any payment information
         * 
         * https://laravel.com/docs/5.8/billing "Payment Methods for Subscriptions"
         * 
         */

        $user = User::find(Auth::user()->id);

        return view('settings.billing.create', [
            'intent' => $user->createSetupIntent()
        ]);
        

    }

    public function update() {

        $user = User::find(Auth::user()->id);

        $user->updateDefaultPaymentMethod($paymentMethod);

    }

    public function destory() {

        $paymentMethod->delete();

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

    /**
     * BILLING CODE PROVIDED BY WHITE JULY
     * 
     * 
     * NOTE!!!!! THIS IS WHERE I LEFT OFF   
     * 
     * Look at the instructions by laravel. it looks like their process is correct
     * and stripe gives you the "what to do on success"
     * the fuction to store the card via their api
     * 
     * https://stripe.com/docs/payments/cards/saving-cards-without-payment
     * 
     * step 5. custopmer::create or attach a paymentmethod
     * 
     * after you do that, then you want to pass the intent to the $user->addPaymentMethod($paymentMethod);
     * 
     * https://laravel.com/docs/5.8/billing#adding-payment-methods
     * 
     * i think this works for both ACH and cc. but I could be wrong. it's probably just for cards
     */
    
    public function createCard() {
        return view('settings.billing.createCard');
    }

    public function storeCard(Request $request) {

        $user = User::find(Auth::user()->id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $card = \Stripe\Customer::createSource(
            $user->stripe_id,
            [
                'card' => [
                    'number' => $request->input('number'),
                    'exp_month' => $request->input('month'),
                    'exp_year' => $request->input('year'),
                    'cvc' => $request->input('cvc'),
                ],
            ]
        );

        $cards = \Stripe\Customer::allSources(
            $user->stripe_id,
            [
                'object' => 'card',
            ]
        );

        $invoices = \Stripe\Invoice::all(
            [
                "limit" => 15,
                "customer" => $user->stripe_id,
            ]
        );

        $subscriptions = \Stripe\Subscription::all([
            "customer" => $user->stripe_id,

        ]);

        return redirect()
            ->route('settings.billing.index', [
            'cards' => $cards, 
            'invoices' => $invoices,
        ])->with('info', 'Your card was added successfully!');                   

    }

}
