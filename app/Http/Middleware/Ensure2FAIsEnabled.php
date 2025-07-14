<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ensure2FAIsEnabled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user is not logged in, skip (let other middleware handle it)
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Only enforce for superadmins
        if ($user->hasRole('superadmin')) {
            // two_factor_secret is null if 2FA not enabled
            if (is_null($user->two_factor_secret)) {
                return redirect()->route('two-factor.setup');
            }
        }

        return $next($request);
    }
}
