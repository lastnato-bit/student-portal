<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSuperadminIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // If no user is logged in
        if (!Auth::check()) {
            return redirect('/login/superadmin'); // 👈 Your custom login URL
        }

        // If the logged-in user is not a superadmin
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Access denied. Superadmin role required.');
        }

        return $next($request);
    }
}
