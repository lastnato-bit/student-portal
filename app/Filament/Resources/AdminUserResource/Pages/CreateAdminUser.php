<?php

namespace App\Filament\Resources\AdminUserResource\Pages;

use App\Mail\SendAdminCredentials;
use App\Filament\Resources\AdminUserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CreateAdminUser extends CreateRecord
{
    protected static string $resource = AdminUserResource::class;

    // ✅ Fix: Declare this property so the IDE stops marking it red
    protected ?string $temporaryPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    if (empty($data['password'])) {
        $rawPassword = Str::random(12);
        $data['password'] = Hash::make($rawPassword);

        // Store for email use
        $this->temporaryPassword = $rawPassword;
    }

    // ✅ Enforce must_change_password = true
    $data['must_change_password'] = true;

    return $data;
}

    protected function afterCreate(): void
    {
        $this->record->assignRole('admin');

        if ($this->temporaryPassword) {
            Mail::to($this->record->email)->send(
                new SendAdminCredentials($this->record->email, $this->temporaryPassword)
            );
        }
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
