<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SuperadminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $firstname;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->otp = $user->otp_code;
        $this->firstname = $user->firstname;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Superadmin Account')
                    ->view('emails.superadmin-otp')
                    ->with([
                        'otp' => $this->otp,
                        'firstname' => $this->firstname,
                    ]);
    }
}
