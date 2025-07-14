<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class SuperadminPasswordResetConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $confirmUrl;
    public $denyUrl;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        // ✅ Encrypt the user ID for the signed routes
        $encryptedId = encrypt($this->user->id);

        // ✅ FIXED: Use the correct route for signed URL confirmation
        $this->confirmUrl = URL::temporarySignedRoute(
            'superadmin.confirm-reset', // ✅ MUST MATCH your route in web.php
            now()->addMinutes(30),
            ['id' => $encryptedId]
        );

        // ✅ Deny route also signed (optional fallback link)
        $this->denyUrl = URL::temporarySignedRoute(
            'superadmin.deny-reset',
            now()->addMinutes(30),
            ['id' => $encryptedId]
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirm Password Reset Request')
            ->view('emails.superadmin.superadmin-reset-confirmation')
            ->with([
                'user' => $this->user,
                'confirmUrl' => $this->confirmUrl,
                'denyUrl' => $this->denyUrl,
            ]);
    }
}
