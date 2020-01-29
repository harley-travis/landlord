<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Mail\PaymentConfirmation;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends Controller {
    
    public function handleChargeFailed($payload) {

        //Mail::to($user->email)->send(new PaymentConfirmation($user, $total));

    }

    public function handleChargeSucceeded($payload) {

        $user = Auth::user();
        $total = 'test money';
        Mail::to($user->email)->send(new PaymentConfirmation($user, $total));

    }

}
