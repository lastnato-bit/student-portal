<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Filament\Facades\Filament;

class AdminLoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ Check for must_change_password
        if ($user->hasRole('admin') && $user->must_change_password) {
            return redirect()->route('admin.force-password-change');
        }

        // ✅ Otherwise go to admin dashboard
        return redirect()->intended(Filament::getUrl('admin') . '/dashboard');
    }
}
