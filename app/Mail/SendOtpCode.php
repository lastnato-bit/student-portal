<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SendOtpCode extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->otp = $user->otp_code;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your OTP Verification Code')
                    ->view('emails.superadmin-otp')
                    ->with([
                        'name' => $this->user->firstname . ' ' . $this->user->lastname,
                        'otp' => $this->otp,
                        'expires' => $this->user->otp_expires_at->format('h:i A'),
                    ]);
    }
}
