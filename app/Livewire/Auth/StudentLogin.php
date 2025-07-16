<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

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

        $user = User::where('email', $this->email)->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        if (! $user->hasRole('student')) {
            throw ValidationException::withMessages([
                'email' => 'Only student accounts can login here.',
            ]);
        }

        Auth::login($user, $this->remember);

        return redirect()->route('student.dashboard');
    }

    public function render()
    {
        return view('auth.login')->layout('layouts.guest');
    }
}
