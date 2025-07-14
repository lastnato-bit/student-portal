<?php

namespace App\Livewire\Superadmin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerifyOtp extends Component
{
    public $userId;
    public $otp = '';

    public function mount($id)
    {
        $this->userId = $id;
    }

    public function verify()
    {
        $user = User::find($this->userId);

        if (!$user || $user->otp_code !== $this->otp || now()->greaterThan($user->otp_expires_at)) {
            session()->flash('error', 'Invalid or expired OTP.');
            return;
        }

        // Mark user as verified
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->is_verified = true;
        $user->save();

        // Optionally log in the user
        Auth::login($user);

        session()->flash('success', 'Account verified successfully!');

        return redirect('/superadmin'); // or dashboard route
    }

    public function render()
    {
        return view('livewire.superadmin.verify-otp')
            ->layout('layouts.guest');
    }
}
