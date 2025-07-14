<?php

namespace App\Actions;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FortifyLoginResponse implements LoginResponseContract
{
    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        // If not a student, immediately log out and redirect back with error
        if (! $user->hasRole('student')) {
            Auth::logout();
            
            return redirect('/login')
                ->withErrors(['email' => 'Only students may log in here.']);
        }

        // Otherwise proceed to intended URL or student dashboard
        return redirect()->intended('/dashboard');
    }
}
