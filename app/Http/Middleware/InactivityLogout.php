<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InactivityLogout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $timeout = 15 * 60; // 15 minutes in seconds
            $lastActivity = session('lastActivityTime');
            $now = time();

            if ($lastActivity && ($now - $lastActivity) > $timeout) {
                Auth::logout();
                session()->flush();

                return redirect('/login')->withErrors([
                    'message' => 'You have been logged out due to inactivity.',
                ]);
            }

            session(['lastActivityTime' => $now]);
        }

        return $next($request);
    }
}
