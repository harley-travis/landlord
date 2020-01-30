<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $total)
    {
        $this->user = $user;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@senrent.com')
                    ->subject('Rent Payment Failed')
                    ->markdown('emails.payment.failed');
    }
}
