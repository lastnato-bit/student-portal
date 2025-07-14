<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AdminLogin extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $recaptchaToken = ''; // ✅ This holds the reCAPTCHA token

    // ✅ Listener for the Alpine + Livewire bridge
    protected $listeners = ['recaptchaCompleted' => 'setRecaptchaToken'];

    public function setRecaptchaToken()
{
    $this->recaptchaToken = request()->input('components.0.calls.0.params.1.token', '');
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

        Auth::login($user, $this->remember);

        return redirect('/admin');
    }

    public function render()
    {
        return view('auth.admin-login')
            ->layout('layouts.guest');
    }
}
