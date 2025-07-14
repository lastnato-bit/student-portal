<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentSecureResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.student-forgot-password'); // You should have this Blade file
    }

    public function handleResetRequest(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            // ❌ If not found or not student, reject clearly
            if (! $user || ! $user->hasRole('student')) {
                return back()->withErrors(['email' => 'This email is not registered as a student.']);
            }

            // ✅ Generate secure random password
            $newPassword = Str::random(12);
            $user->password = Hash::make($newPassword);
            $user->save();

            // ✅ Email the password
            Mail::raw("Hi {$user->name},\n\nYour password has been reset.\n\nNew Password: {$newPassword}\n\nPlease log in and change your password immediately.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Student Password Reset');
            });

            Log::info("Student password reset success for {$user->email}");

            return back()->with('status', 'A new password has been sent to your email address.');

        } catch (\Exception $e) {
            Log::error("Student password reset error: " . $e->getMessage());
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}
