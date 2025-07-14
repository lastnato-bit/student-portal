<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\FailedLoginResponse;
use Laravel\Fortify\Contracts\AuthenticateUser;
use Laravel\Fortify\Fortify;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthenticateUserAction implements AuthenticateUser
{
    public function __invoke(Request $request)
    {
        Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
        'g-recaptcha-response' => 'required|captcha',
    ])->validate();


        $this->ensureIsNotRateLimited($request);

        if (!Auth::attempt(
            $request->only(Fortify::username(), 'password'),
            $request->boolean('remember')
        )) {
            RateLimiter::hit($this->throttleKey($request));

            return app(FailedLoginResponse::class);
        }

        RateLimiter::clear($this->throttleKey($request));

        $user = Auth::user();

        // ✅ Allow only student role here
        if (!$user->hasRole('student')) {
            Auth::logout();

            throw ValidationException::withMessages([
                Fortify::username() => 'Only student accounts can log in here.',
            ]);
        }

        return app(LoginResponse::class);
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        throw ValidationException::withMessages([
            Fortify::username() => __('Too many login attempts. Please try again in :seconds seconds.', [
                'seconds' => RateLimiter::availableIn($this->throttleKey($request)),
            ]),
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input(Fortify::username())) . '|' . $request->ip();
    }
}
