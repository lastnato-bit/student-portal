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
use Illuminate\Support\Facades\Crypt;

class SuperadminResetConfirmationController extends Controller
{
    /**
     * Show the custom reset password form after confirmation.
     */
    public function confirm($encryptedId)
{
    try {
        // ✅ Decrypt safely using Crypt
        $userId = Crypt::decryptString($encryptedId);

        $user = User::findOrFail($userId);

        if (! $user->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        // ✅ Generate 6-digit OTP
        $otp = random_int(100000, 999999);

        // ✅ Store in session
        Session::put('superadmin_otp', $otp);
        Session::put('superadmin_id', $userId);

        // ✅ Email OTP
        Mail::to($user->email)->send(new SendOtpToSuperadmin($user, $otp));

        return redirect()->route('superadmin.verify-otp.form', ['id' => $userId]);

    } catch (\Exception $e) {
        Log::error('Superadmin reset confirm error: ' . $e->getMessage());
        abort(403, 'Invalid or expired reset link.');
    }
}


    /**
     * Deny the reset request.
     */
    public function deny($encryptedId)
    {
        return view('auth.superadmin-reset-denied');
    }

    /**
     * Handle the password reset submission with strong validation.
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',            // At least 1 uppercase
                'regex:/[0-9]/',            // At least 1 number
                'regex:/[@$!%*#?&]/',       // At least 1 special character
            ],
        ], [
            'user_id.required' => 'User ID is missing.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 number, and 1 special character.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($request->input('user_id'));

        if (! $user->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect('/login/superadmin')->with('status', 'Password reset successfully. You may now log in.');
    }
}
