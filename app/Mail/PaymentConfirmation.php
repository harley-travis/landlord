<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $total;
    public $date;
    public $confirmationNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $total, $date, $confirmationNumber)
    {
        $this->user = $user;
        $this->total = $total;
        $this->date = $date;
        $this->confirmationNumber = $confirmationNumber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@senrent.com')
                    ->subject('Payment Successful!')
                    ->markdown('emails.payment.confirmation');
    }
}
