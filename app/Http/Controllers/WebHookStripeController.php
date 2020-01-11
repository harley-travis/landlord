<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Mail\PaymentConfirmation;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebHookStripeController extends CashierController {
    
    public function handleSourceCanceled($payload) {}

    public function handleSourceFailed($payload) {}

    public function handleTransferCreated($payload) {}

    public function handleTransferFailed($payload) {}

    public function handleTransferPaid($payload) {}

    public function handleTransferCanceled($payload) {}

    public function handleChargeCaptured($payload) {}

    public function handleChargeExpired($payload) {}

    public function handleChargeFailed($payload) {}

    public function handleChargeSucceeded($payload) {

        dd('we in the web hooks now');
        
        $customerId = $payload['data']['object']['customer'];

        $user = User::find(Auth::user()->id);

        Mail::to($user->email)->send(new PaymentConfirmation($user, $total));

    }

}
