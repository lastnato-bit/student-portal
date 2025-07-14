<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            if ($request->is('superadmin') || $request->is('superadmin/*')) {
                return route('filament.superadmin.auth.login');
            }

            if ($request->is('admin') || $request->is('admin/*')) {
                return route('filament.admin.auth.login');
            }

            return route('login'); // Default Jetstream login (for students)
        }

        return null;
    }
}
