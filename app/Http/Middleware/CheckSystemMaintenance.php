<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckSystemMaintenance
{
    public function handle($request, Closure $next)
    {
        // Maintenance mode is enabled
        if (Cache::get('system_maintenance_enabled')) {
            // If user is not logged in or not a superadmin
            if (!Auth::check() || !Auth::user()->hasRole('superadmin')) {
                return response()->view('maintenance'); // create this Blade view
            }
        }

        return $next($request);
    }
}
