<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use App\Mail\PaymentConfirmation;
use App\Mail\PaymentFailed;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController {
    
    public function handleChargeFailed($payload) {

        $stripe_id = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', '=', $stripe_id)->first();
        $email = $user->email;
        $total = $payload['data']['object']['amount'];

        Mail::to($email)->send(new PaymentFailed($user, $total));

        return new Response('received', 200);

    }

    public function handleChargeSucceeded($payload) {

        $stripe_id = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', '=', $stripe_id)->first();
        $email = $user->email;
        $total = $payload['data']['object']['amount'];

        Mail::to($email)->send(new PaymentConfirmation($user, $total));

        return new Response('received', 200);

    }

}
