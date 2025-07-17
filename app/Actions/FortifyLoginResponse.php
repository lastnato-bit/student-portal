<?php

namespace App\Actions;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class FortifyLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // 🔐 Handle 2FA redirect
        if (session()->has('login.id')) {
            return redirect()->intended('/two-factor-challenge');
        }

        // 🔐 Role-based redirection
        $user = $request->user();

        if ($user->hasRole('superadmin')) {
            return redirect()->intended('/superadmin/dashboard');
        }

        if ($user->hasRole('admin')) {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/student/dashboard');
    }
}
