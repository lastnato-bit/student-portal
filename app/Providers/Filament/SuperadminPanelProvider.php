<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages;
use Filament\Widgets;
use Filament\Support\Colors\Color;
use Illuminate\Http\Request;
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

use App\Filament\Widgets\SuperadminOverview;
use App\Filament\Resources\AdminUserResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\HolidayResource;
use Filament\Navigation\NavigationItem;
use App\Filament\Superadmin\Widgets\WelcomeSuperadminWidget;

class SuperadminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('superadmin')
            ->path('superadmin')
            ->authGuard('web')
            ->sidebarFullyCollapsibleOnDesktop()
            ->brandName('Student Portal')
            
            

            // ✅ Custom logo and favicon (optional)
            ->brandLogo(fn () => view('components.custom-logo')) // <-- add your logo path here
            ->favicon(asset('favicon.ico'))       // <-- optional favicon

            // ✅ Custom theme for a cleaner look
            

            // ✅ Primary color set to fuchsia (already present)
            ->colors([
                'primary' => Color::Fuchsia,
            ])

            // ✅ Discover resources and pages
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->resources([
                AdminUserResource::class,
                UserResource::class,
                HolidayResource::class,
            ])

            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])

            ->widgets([
                WelcomeSuperadminWidget::class,
                SuperadminOverview::class,
            ])

            // ✅ Top right user menu
            ->userMenuItems([
                UserMenuItem::make()
                    ->label('Profile & 2FA')
                    ->url(fn () => route('profile.show'))
                    ->icon('heroicon-o-user'),

                UserMenuItem::make()
                    ->label('Log out')
                    ->url(fn () => route('superadmin.logout'))
                    ->icon('heroicon-o-arrow-left-on-rectangle'),
            ])

            // ✅ Custom navigation
            ->navigationItems([
                NavigationItem::make('Manage Holidays')
                    ->url(fn () => HolidayResource::getUrl('index', panel: 'superadmin'))
                    ->icon('heroicon-o-calendar')
                    ->group('Academic Management'),
            ])

            // ✅ Required middleware
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
                \App\Http\Middleware\EnsureSuperadminIsAuthenticated::class,
            ]);
    }

    public function canAccessPanel(Request $request): bool
    {
        $user = $request->user();
        return $user && $user->hasRole('superadmin');
    }
}
