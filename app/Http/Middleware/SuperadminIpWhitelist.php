<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperadminIpWhitelist
{
    /**
     * List of allowed IPs for superadmin access.
     */
    protected array $allowedIps = [
        '127.0.0.1', // localhost
        '::1',       // IPv6 localhost
        // Add your public IPs below
        // '123.456.78.90',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->ip(), $this->allowedIps)) {
            abort(403, 'Access denied. Your IP address is not allowed.');
        }

        return $next($request);
    }
}
