<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    /**
     * Show OTP form for Superadmin
     */
    public function showOtpForm($id)
    {
        try {
            $user = User::findOrFail($id);
            Log::info("Superadmin OTP form requested for: {$user->email}");

            if (! $user->hasRole('superadmin')) {
                Log::warning("Unauthorized Superadmin OTP access by: {$user->email}");
                abort(403, 'Unauthorized');
            }

            return view('auth.superadmin-enter-otp', ['user' => $user]);

        } catch (\Exception $e) {
            Log::error("Superadmin OTP form failed: " . $e->getMessage());
            abort(403, 'Invalid or expired reset request.');
        }
    }

    /**
     * Verify OTP for Superadmin
     */
    public function verifyOtp(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            Log::info("Verifying Superadmin OTP for: {$user->email}");

            if (! $user->hasRole('superadmin')) {
                Log::warning("Unauthorized Superadmin OTP attempt by: {$user->email}");
                abort(403, 'Unauthorized');
            }

            $request->validate([
                'otp' => ['required', 'digits:6'],
            ]);

            if (
                $user->otp_code !== $request->otp ||
                !$user->otp_expires_at ||
                Carbon::now()->gt($user->otp_expires_at)
            ) {
                Log::warning("Invalid/expired Superadmin OTP for: {$user->email}");
                return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
            }

            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            session(['superadmin_reset_id' => $user->id]);

            Log::info("Superadmin OTP verified: {$user->email}");

            return redirect()->route('superadmin.reset.form');

        } catch (\Exception $e) {
            Log::error("Superadmin OTP verification failed: " . $e->getMessage());
            abort(403, 'OTP verification failed.');
        }
    }

    /**
     * Show OTP form for Admin
     */
    public function showAdminOtpForm($id)
    {
        try {
            $user = User::findOrFail($id);
            Log::info("Admin OTP form requested for: {$user->email}");

            if (! $user->hasRole('admin')) {
                Log::warning("Unauthorized Admin OTP access by: {$user->email}");
                abort(403, 'Unauthorized');
            }

            return view('auth.admin-enter-otp', ['user' => $user]);

        } catch (\Exception $e) {
            Log::error("Admin OTP form failed: " . $e->getMessage());
            abort(403, 'Invalid or expired reset request.');
        }
    }

    /**
     * Verify OTP for Admin
     */
    public function verifyAdminOtp(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            Log::info("Verifying Admin OTP for: {$user->email}");

            if (! $user->hasRole('admin')) {
                Log::warning("Unauthorized Admin OTP attempt by: {$user->email}");
                abort(403, 'Unauthorized');
            }

            $request->validate([
                'otp' => ['required', 'digits:6'],
            ]);

            if (
                $user->otp_code !== $request->otp ||
                !$user->otp_expires_at ||
                Carbon::now()->gt($user->otp_expires_at)
            ) {
                Log::warning("Invalid/expired Admin OTP for: {$user->email}");
                return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
            }

            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            session(['admin_reset_id' => $user->id]);

            Log::info("Admin OTP verified: {$user->email}");

            return redirect()->route('admin.reset.form');

        } catch (\Exception $e) {
            Log::error("Admin OTP verification failed: " . $e->getMessage());
            abort(403, 'OTP verification failed.');
        }
    }
}
