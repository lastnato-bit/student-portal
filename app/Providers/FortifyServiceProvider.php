<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\PasswordResetResponse as PasswordResetResponseContract;
use App\Actions\FortifyLoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ✅ Custom login response binding
        $this->app->singleton(
            LoginResponseContract::class,
            FortifyLoginResponse::class
        );

        // ✅ Custom password reset response redirect
        $this->app->singleton(PasswordResetResponseContract::class, function () {
            return new class implements PasswordResetResponseContract {
                public function toResponse($request)
                {
                    // You may change this to any other role-based redirect
                    return redirect('/login/admin');
                }
            };
        });
    }

    public function boot(): void
    {
        // 🧩 Fortify Actions
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        // ✅ Custom login view for students
        Fortify::loginView(function () {
            return view('auth.login'); // You control this view: /resources/views/auth/login.blade.php
        });

        // ✅ Authenticate only students with 'active' status
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            // Check if user exists and password is valid
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return null;
            }

            // Check if the user has the 'student' role
            if (! $user->hasRole('student')) {
                return null;
            }

            // ✅ Check if student status is 'active'
            if ($user->student?->status !== 'active') {
                return null;
            }

            return $user;
        });

        // ✅ Rate limiters for security
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by(Str::lower($email) . '|' . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
