<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Mail\PaymentConfirmation;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController {
    
    public function handleChargeFailed($payload) {

        $user = $payload['data']['object']['customer'];
        $email = $payload['data']['object']['customer']; // i think i might have to capture their email address and save that to stripe
        $total = $payload['data']['object']['customer'];
        
        Mail::to('harley.travis2@gmail.com')->send(new PaymentConfirmation($user, $total));

        return new Response('Webhook Handled, yeah boy', 200);

    }

    public function handleChargeSucceeded($payload) {


        $user = $payload['data']['object']['customer'];
        $email = $payload['data']['object']['customer']; // i think i might have to capture their email address and save that to stripe
        $total = $payload['data']['object']['customer'];
        
        Mail::to('harley.travis2@gmail.com')->send(new PaymentConfirmation($user, $total));



        return new Response('Webhook Handled, yeah boy', 200);

    }

}
