<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SuperadminPasswordResetConfirmation;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the forgot password request for Superadmin.
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

        // Send confirmation email with reset approval options
        Mail::to($user->email)->send(new SuperadminPasswordResetConfirmation($user));

        return back()->with('status', 'We’ve sent a confirmation email to verify this request.');
    }
}
