<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureadminIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // If no user is logged in
        if (!Auth::check()) {
            return redirect('/login/admin'); // 👈 Your custom login URL
        }

        // If the logged-in user is not a superadmin
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Access denied. admin role required.');
        }

        return $next($request);
    }
}
