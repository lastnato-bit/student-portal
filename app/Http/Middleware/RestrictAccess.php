<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictAccess
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Example: Restrict by IP or condition
        if ($role === 'superadmin' && !in_array($request->ip(), ['127.0.0.1'])) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
