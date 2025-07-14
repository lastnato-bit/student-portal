<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\Pages;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Middleware\EnsureAdminIsAuthenticated;
use App\Http\Middleware\ForceAdminPasswordChange;

use App\Filament\Admin\Widgets\WelcomeAdminWidget;
use App\Filament\Widgets\AdminOverview;
use App\Filament\Resources\HolidayResource;

class AdminPanelProvider extends PanelProvider
{
    
        public function panel(Panel $panel): Panel
    {
       return $panel
    ->default()
    ->id('admin')
    ->path('admin')
    ->authGuard('web')
    ->sidebarFullyCollapsibleOnDesktop()
    ->brandName('Student Portal ')


    
    


    ->colors([
        'primary' => \Filament\Support\Colors\Color::Fuchsia,
    ])

            // ✅ Custom Login Route Override
            ->routes(function () {
                Route::post('/admin/login', [AdminLoginController::class, 'store'])
                    ->name('filament.admin.auth.login');
            })

            ->colors([
                'primary' => Color::Amber,
            ])

            // ✅ Resources
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->resources([
                HolidayResource::class,
            ])

            // ✅ Pages
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])

            // ✅ Widgets
            ->widgets([
                WelcomeAdminWidget::class, // 👋 Welcome widget (top)
                AdminOverview::class,      // 📊 Stats/overview
            ])

            // ✅ User Menu Items
            ->userMenuItems([
                UserMenuItem::make()
                    ->label('Profile & 2FA')
                    ->url(fn () => route('profile.show'))
                    ->icon('heroicon-o-user'),

                UserMenuItem::make()
                    ->label('Logout')
                    ->url(fn () => route('admin.logout'))
                    ->icon('heroicon-o-arrow-left-on-rectangle'),
            ])

            // ✅ Navigation Items
            ->navigationItems([
                NavigationItem::make('Manage Holidays')
                    ->url(fn () => HolidayResource::getUrl('index', panel: 'admin'))
                    ->icon('heroicon-o-calendar')
                    ->group('Academic Management'),
            ])

            // ✅ Middleware Stack
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                EnsureAdminIsAuthenticated::class,
                ForceAdminPasswordChange::class,
            ]);
    }

    public function canAccessPanel(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->hasRole('admin');
    }
}
