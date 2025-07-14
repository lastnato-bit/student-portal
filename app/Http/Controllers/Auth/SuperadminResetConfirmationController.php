<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendOtpToSuperadmin;

class SuperadminResetController extends Controller
{
    /**
     * Show the Superadmin forgot password form.
     */
    public function showRequestForm()
    {
        return view('auth.superadmin-forgot-password');
    }

    /**
     * Send OTP to Superadmin's email directly after email is submitted.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! $user->hasRole('superadmin')) {
            return back()->withErrors(['email' => 'No superadmin account found with that email.']);
        }

        try {
            $otp = random_int(100000, 999999);
            Session::put('superadmin_otp', $otp);
            Session::put('superadmin_id', $user->id);

            // Send OTP email
            Mail::to($user->email)->send(new SendOtpToSuperadmin($user, $otp));

            return redirect()->route('superadmin.verify-otp.form', ['id' => encrypt($user->id)]);
        } catch (\Exception $e) {
            Log::error('Error sending OTP to superadmin: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again later.']);
        }
    }

    /**
     * Show the reset password form after OTP verification.
     */
    public function showResetForm(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (! $user->hasRole('superadmin')) {
            abort(403, 'Unauthorized access.');
        }

        return view('auth.superadmin-reset-form', ['user' => $user]);
    }

    /**
     * Handle password reset submission.
     */
    public function submitReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',       // At least 1 uppercase letter
                'regex:/[0-9]/',       // At least 1 number
                'regex:/[@$!%*#?&]/',  // At least 1 special character
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'password.regex' => 'Password must include an uppercase letter, a number, and a special character.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($request->user_id);

        if (! $user->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login.superadmin')->with('status', 'Password reset successful. You may now log in.');
    }
}
