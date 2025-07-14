<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SuperadminResetController extends Controller
{
    /**
     * Show the Superadmin "Forgot Password" form.
     */
    public function showRequestForm()
    {
        return view('auth.superadmin-forgot-password');
    }

    /**
     * Handle Superadmin OTP request.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! $user->hasRole('superadmin')) {
            return back()->withErrors(['email' => 'This email is not registered as a superadmin.']);
        }

        // ✅ Generate and store OTP
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // ✅ Send OTP via email
        Mail::raw("Hi {$user->name},\n\nYour OTP for resetting your password is:\n\n{$otp}\n\nThis OTP will expire in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Superadmin OTP Code');
        });

        return redirect()->route('superadmin.verify-otp.form', ['id' => $user->id])
                         ->with('status', 'OTP sent to your email.');
    }

    /**
     * Show the password reset form if OTP was verified.
     */
    public function showResetForm(Request $request)
    {
        if (! session()->has('superadmin_reset_id')) {
            abort(403, 'Unauthorized access to password reset form.');
        }

        $user = User::findOrFail(session('superadmin_reset_id'));

        return view('auth.superadmin-reset-password', compact('user'));
    }

    /**
     * Handle password reset submission.
     */
    public function submitReset(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',       // At least one uppercase letter
                'regex:/[0-9]/',       // At least one digit
                'regex:/[@$!%*#?&]/',  // At least one special character
            ],
        ], [
            'password.regex' => 'Password must include at least one uppercase letter, one number, and one special character.',
        ]);

        $userId = session('superadmin_reset_id');
        $user = User::findOrFail($userId);

        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session()->forget('superadmin_reset_id');

        return redirect()->route('login.superadmin')->with('status', 'Password has been reset successfully.');
    }
}
