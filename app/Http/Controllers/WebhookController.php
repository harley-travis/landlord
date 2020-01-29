<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Mail\PaymentConfirmation;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController {
    
    public function handleChargeFailed($payload) {

        //Mail::to($user->email)->send(new PaymentConfirmation($user, $total));

    }

    public function handleChargeSucceeded($payload) {

        // $user = Auth::user();
        // $total = 'test money';

        $user = 'Travis';
        $total = '1000';
        
        //Mail::to('harley.travis2@gmail.com')->send(new PaymentConfirmation($user, $total));



        return new Response('Webhook Handled, yeah boy', 200);

    }

}
