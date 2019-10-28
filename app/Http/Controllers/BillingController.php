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

        return view('settings.billing.index', ['paymentMethods' => $paymentMethods]);

    }

    public function create() {

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

    public function store() {

        $user = User::find(Auth::user()->id);

        $user->addPaymentMethod($paymentMethod);

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

}
