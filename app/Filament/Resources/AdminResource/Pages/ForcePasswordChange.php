<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\Page;

class ForcePasswordChange extends Page
{
    protected static string $resource = AdminResource::class;

    protected static string $view = 'filament.resources.admin-resource.pages.force-password-change';

    public static bool $shouldRegisterNavigation = false;

    public static function getRouteName(?string $panel = null): string
    {
        return 'admin.force-password-change';
    }

    public static function getSlug(): string
    {
        return 'force-password-change';
    }
}
