<?php

namespace App\Mail;

use App\User;
use App\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MaintenanceCreated extends Mailable {

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
                        ->subject('Maintenance request submitted successfully')
                        ->markdown('emails.maintenance.inProgress');

    }
}
