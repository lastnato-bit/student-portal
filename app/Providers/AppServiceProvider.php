<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Anhskohbo\NoCaptcha\NoCaptcha;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ✅ Bind NoCaptcha properly
        $this->app->singleton(NoCaptcha::class, function ($app) {
            return new NoCaptcha(
                config('captcha.secret'),
                config('captcha.sitekey'),
                config('captcha.options', [])
            );
        });
    }

    public function boot(): void
    {
        // ✅ Logout route for Superadmin
        Route::post('/superadmin/logout', function () {
            Auth::logout();
            return redirect('/login/superadmin');
        })->name('filament.superadmin.auth.logout');

       Validator::extendImplicit('captcha', function ($attribute, $value, $parameters, $validator) {
    return app(NoCaptcha::class)->verifyResponse($value);
});

if (file_exists(app_path('Helpers/helpers.php'))) {
        require_once app_path('Helpers/helpers.php');
    }

    }
}
