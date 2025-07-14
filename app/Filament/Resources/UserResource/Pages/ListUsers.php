<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        // ✅ Show "New User" button only to superadmin
        if (auth()->user()?->hasRole('superadmin')) {
            return [
                Actions\CreateAction::make(),
            ];
        }

        return []; // 🔒 No actions for admin
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasRole('superadmin');
    }
}
