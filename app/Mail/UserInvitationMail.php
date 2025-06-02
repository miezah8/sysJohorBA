<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inviteUrl;

    public function __construct($inviteUrl)
    {
        $this->inviteUrl = $inviteUrl;
    }

    public function build()
    {
        return $this->markdown('emails.user.invite')
                    ->subject('You’re Invited to Join the System')
                    ->with(['inviteUrl' => $this->inviteUrl]);
    }
}
