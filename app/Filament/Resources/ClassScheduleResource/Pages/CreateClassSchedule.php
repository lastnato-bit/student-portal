<?php

namespace App\Filament\Resources\ClassScheduleResource\Pages;

use App\Filament\Resources\ClassScheduleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateClassSchedule extends CreateRecord
{
    protected static string $resource = ClassScheduleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically assign department for admin
        if (Auth::user()->hasRole('admin')) {
            $data['department_id'] = Auth::user()->department_id;
        }

        Log::info('Create Class Schedule - Form Data:', $data);

        return $data;
    }

    protected function afterCreate(): void
    {
        Log::info('Class schedule created successfully for section ID: ' . $this->record->section_id);
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
