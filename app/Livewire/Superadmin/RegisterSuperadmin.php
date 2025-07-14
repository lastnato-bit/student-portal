<?php

namespace App\Livewire\Superadmin;

use Livewire\Component;
use App\Models\User;
use App\Models\SuperadminCreationLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use App\Mail\SuperadminOtpMail;

class RegisterSuperadmin extends Component
{
    public $firstname = '';
    public $middlename = '';
    public $lastname = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $superadminRole = Role::where('name', 'superadmin')->first();
        $hasSuperadmins = $superadminRole && $superadminRole->users()->exists();

        // Restrict if superadmin already exists and current user is not one
        if ($hasSuperadmins && (!Auth::check() || !Auth::user()->hasRole('superadmin'))) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'firstname' => 'required|string|max:50',
            'middlename' => 'nullable|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(12)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        $otpExpiresAt = now()->addMinutes(10);

        // Create user without logging them in
        $user = User::create([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'must_change_password' => true,
            'otp_code' => $otp,
            'otp_expires_at' => $otpExpiresAt,
            'email_verified_at' => null,
            'is_verified' => false,
        ]);

        // Assign role
        $user->assignRole('superadmin');

        // ✅ Logout properly using guard name to prevent auto-login
        auth('web')->logout();

        // Log creator if authenticated
        if (Auth::check()) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties(['email' => $user->email])
                ->log('Superadmin account created');
        }

        // Log creation for audit
        SuperadminCreationLog::create([
            'created_by' => Auth::id(),
            'new_superadmin_id' => $user->id,
            'new_superadmin_email' => $user->email,
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new SuperadminOtpMail($user));

        // Flash message
        session()->flash('success', 'Superadmin created. Please check your email for the OTP code to verify your account.');

        // Reset form fields
        $this->reset([
            'firstname', 'middlename', 'lastname',
            'email', 'password', 'password_confirmation',
        ]);

        // Redirect to OTP verification form
        return redirect()->route('superadmin.verify-otp.form', ['id' => $user->id]);
    }

    public function render()
    {
        return view('livewire.superadmin.register-superadmin')
            ->layout('layouts.guest');
    }
}
