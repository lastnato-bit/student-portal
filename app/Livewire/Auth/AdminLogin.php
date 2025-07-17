<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Laravel\Fortify\Features;

class AdminLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $recaptchaToken = ''; // ✅ This holds the reCAPTCHA token

    // ✅ Listener for the Alpine + Livewire bridge
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
            'recaptchaToken' => 'required|captcha', // ✅ validate correct field
        ]);

        $user = User::where('email', $this->email)->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        if (! $user->hasRole('admin')) {
            throw ValidationException::withMessages([
                'email' => 'Only admin accounts can login here.',
            ]);
        }

        // ✅ Handle 2FA manually if enabled
        if (Features::enabled(Features::twoFactorAuthentication()) && $user->two_factor_secret) {
            Auth::logout();
            session(['login.id' => $user->id]);
            return redirect()->route('two-factor.login');
        }

        Auth::login($user, $this->remember);

        return redirect('/admin');
    }

    public function render()
    {
        return view('auth.admin-login')
            ->layout('layouts.guest');
    }
}
