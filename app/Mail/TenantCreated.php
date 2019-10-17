<?php

namespace App\Mail;

use App\Tenant;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Contracts\Queue\ShouldQueue;

class TenantCreated extends Mailable {

    use Queueable, SerializesModels;

    public $tenant;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(Tenant $tenant, User $user)  {

        $this->tenant = $tenant;
        $this->user = $user;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {

        return $this->from('noreply@senrent.com')
                    ->subject('Welcome to SenRent! Login to start paying your rent online')
                    ->view('emails.test');
    }
}
