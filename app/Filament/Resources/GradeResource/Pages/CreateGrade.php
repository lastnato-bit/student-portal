<?php

namespace App\Filament\Resources\GradeResource\Pages;

use App\Filament\Resources\GradeResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ClassSchedule;

class CreateGrade extends CreateRecord
{
    protected static string $resource = GradeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $schedule = ClassSchedule::with('course')->find($data['class_schedule_id']);

        if ($schedule) {
            $data['semester'] = $schedule->semester;
            $data['school_year'] = $schedule->school_year;
            $data['subject'] = $schedule->course->name ?? 'Unknown Subject';
        }

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
