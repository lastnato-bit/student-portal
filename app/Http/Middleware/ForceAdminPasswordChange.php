<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceAdminPasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Optional: Logging for debug (fine in dev, remove in prod)
        if ($user) {
            logger('ForceAdminPasswordChange triggered for: ' . $user->email);
        }

        // ✅ Apply only if:
        // - user is logged in
        // - has role admin
        // - must_change_password is true
        // - not already on password change routes or logging out
        if (
            $user &&
            $user->hasRole('admin') &&
            $user->must_change_password &&
            !$request->is('admin/force-password-change') &&
            !$request->is('admin/force-password-change/*') &&
            !$request->is('admin/logout')
        ) {
            return redirect()->route('admin.force-password-change');
        }

        return $next($request);
    }
}
