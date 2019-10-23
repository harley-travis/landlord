<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class BillingController extends Controller {
    
    public function index() {

        return view('settings.billing.index');

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

}
