<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Mail\PaymentConfirmation;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController {
    
    public function handleChargeFailed($payload) {

        // $email = $payload['data']['metadata']['email'];
        // $user = User::where('email', '=', $email);
        // $total = $payload['data']['object']['amount'];

        //Mail::to($email)->send(new PaymentConfirmation($user, $total));

        return new Response('received', 200);

    }

    public function handleChargeSucceeded($payload) {


        $email = $payload['data']['metadata']['email'];
        $user = User::where('email', '=', $email);
        $total = $payload['data']['object']['amount'];

        Mail::to($email)->send(new PaymentConfirmation($user, $total));

        return new Response('Webhook Handled, yeah boy', 200);

    }

    public function handleChargeExpired($payload) {

        //$email = $payload['data']['metadata']['email'];
        //$user = User::where('email', '=', $email);
        //$total = $payload['data']['object']['amount'];

        $total = 'travis';

    }

}
