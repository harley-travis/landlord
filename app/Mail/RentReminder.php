<?php

namespace App\Mail;

use App\User;
use App\Tenant;
use App\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RentReminder extends Mailable {

    use Queueable, SerializesModels;

    public $tenant;
    public $user;
    public $property;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tenant $tenant, User $user, Property $property) {
        
        $this->tenant = $tenant;
        $this->user = $user;
        $this->property = $property;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {

        return $this->from('noreply@senrent.com')
                        ->subject('Your rent is coming due')
                        ->markdown('emails.rent.reminder');
    }
}
