<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function build(): self
    {
        return $this->subject('Your Admin Account Credentials')
            ->view('emails.send-admin-credentials')
            ->with([
                'email' => $this->email,
                'password' => $this->password,
            ]);
    }
}
