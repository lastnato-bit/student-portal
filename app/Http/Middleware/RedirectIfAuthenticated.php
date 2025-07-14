<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on user role (adjust as needed)
                $user = Auth::user();

                if ($user->hasRole('superadmin')) {
                    return redirect('/superadmin');
                }

                if ($user->hasRole('admin')) {
                    return redirect('/admin');
                }

                if ($user->hasRole('employer')) {
                    return redirect('/employer');
                }

                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
