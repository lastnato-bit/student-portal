<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\SendStudentCredentialsMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendStudentCredentialsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public string $password) {

    }

public function handle(): void
{
    Mail::to($this->user->email)
        ->send(new SendStudentCredentialsMail($this->user, $this->password));
}
}
