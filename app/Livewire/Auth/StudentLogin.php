<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
class StudentLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $recaptchaToken = '';

    protected $listeners = ['recaptchaCompleted' => 'setRecaptchaToken'];

    public function setRecaptchaToken($payload = [])
    {
        $this->recaptchaToken = $payload['token'] ?? '';
    }

   public function login()
{
    $this->validate([
        'email' => 'required|email',
        'password' => 'required',
        'recaptchaToken' => 'required|captcha',
    ]);

    $user = \App\Models\User::where('email', $this->email)->first();

    if (! $user || ! Hash::check($this->password, $user->password)) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.',
        ]);
    }

    // 2FA Enabled
    if (Features::enabled(Features::twoFactorAuthentication()) &&
        $user->two_factor_secret &&
        $user->two_factor_confirmed_at) {

        session(['login.id' => $user->id]);
        // 🔒 DO NOT log them in yet
        return redirect()->route('two-factor.login');
    }

    // Proceed to login
    Auth::login($user, $this->remember);
    session()->regenerate();

    return redirect()->intended(route('dashboard'));
}

protected function throttleKey()
{
    return Str::lower($this->email) . '|' . request()->ip();
}

    public function render()
    {
        return view('auth.login')->layout('layouts.guest');
    }
}
