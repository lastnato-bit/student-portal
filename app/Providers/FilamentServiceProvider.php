<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Restrict Filament to superadmin role only
        Gate::define('viewFilament', function ($user) {
            return $user->hasRole(['superadmin','admin']);
        });

        Filament::serving(function () {
            Filament::registerNavigationItems([
                // customize admin sidebar here if needed
            ]);
        });
    }

    public function panelProviders(): array
{
    return [
        \App\Providers\Filament\AdminPanelProvider::class,
        \App\Providers\Filament\SuperadminPanelProvider::class, //<-- MUST BE HERE
    ];
}
}
