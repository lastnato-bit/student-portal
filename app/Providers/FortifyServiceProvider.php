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

        // ✅ Custom login view
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ✅ Role-aware login with 2FA
        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            // ✅ Validate credentials
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return null;
            }

            // 🔒 Students must be active
            if ($user->hasRole('student') && $user->student?->status !== 'active') {
                return null;
            }

            // 🔐 If 2FA is enabled and confirmed, redirect to challenge
            if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
                session(['login.id' => $user->getKey()]);
                return null; // Fortify will redirect to /two-factor-challenge
            }

            // ✅ Login without 2FA
            return $user;
        });

        // ✅ Rate limiters
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by(Str::lower($email) . '|' . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
