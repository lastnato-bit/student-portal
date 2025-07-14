<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AdminResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.admin-forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! $user->hasRole('admin')) {
            return back()->withErrors(['email' => 'This email is not registered as an admin.']);
        }

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::raw("Hi {$user->name},\n\nYour OTP for resetting your admin password is:\n\n{$otp}\n\nThis OTP will expire in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Admin OTP Code');
        });

        return redirect()->route('admin.verify-otp.form', ['id' => $user->id])
                         ->with('status', 'OTP sent to your email.');
    }

    public function showResetForm(Request $request)
    {
        if (! session()->has('admin_reset_id')) {
            abort(403, 'Unauthorized access to password reset form.');
        }

        $user = User::findOrFail(session('admin_reset_id'));

        return view('auth.admin-reset-password', compact('user'));
    }

    public function submitReset(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ], [
            'password.regex' => 'Password must include an uppercase letter, a number, and a special character.',
        ]);

        $userId = session('admin_reset_id');
        $user = User::findOrFail($userId);

        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session()->forget('admin_reset_id');

        return redirect()->route('login.admin')->with('status', 'Password has been reset successfully.');
    }
}
