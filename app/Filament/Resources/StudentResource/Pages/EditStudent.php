<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Wrap in a database transaction
        DB::transaction(function () use (&$data) {
            // Find the linked user model
            $user = User::find($data['user_id']);

            // Update user info if needed
            if ($user) {
                $user->firstname = $data['firstname'] ?? $user->firstname;
                $user->middlename = $data['middlename'] ?? $user->middlename;
                $user->lastname = $data['lastname'] ?? $user->lastname;

                // Only assign department_id if it exists in form data
                if (array_key_exists('department_id', $data)) {
                    $user->department_id = $data['department_id'];
                }

                $user->save();
            }
        });

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return StudentResource::getUrl('index');
    }
}
