<?php

// app/Http/Middleware/RedirectIfPasswordChangeRequired.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfPasswordChangeRequired
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->hasRole('admin') && $user->must_change_password) {
            // Prevent infinite loop
            if (! $request->is('admin/force-password-change')) {
                return redirect()->route('admin.force-password-change');
            }
        }

        return $next($request);
    }
}
