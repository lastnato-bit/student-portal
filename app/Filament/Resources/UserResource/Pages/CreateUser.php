<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\AdminAccountCreated;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $plainPassword = null;

    /**
     * Mutate data BEFORE saving
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['password'])) {
            // Generate a random password
            $this->plainPassword = Str::random(10);

            // Hash and store it
            $data['password'] = Hash::make($this->plainPassword);
        } else {
            // User entered a password manually
            // For security reasons, we do NOT send it in plain text
            $this->plainPassword = null;

            // Still hash it
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    /**
     * After creating the record, send notification
     */
    protected function afterCreate(): void
    {
        $this->record->notify(new AdminAccountCreated($this->plainPassword));
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
