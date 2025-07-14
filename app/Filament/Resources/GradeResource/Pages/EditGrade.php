<?php

namespace App\Filament\Resources\GradeResource\Pages;

use App\Filament\Resources\GradeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\ClassSchedule;

class EditGrade extends EditRecord
{
    protected static string $resource = GradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $schedule = ClassSchedule::find($data['class_schedule_id']);

        if ($schedule) {
            $data['subject'] = $schedule->subject;
            $data['semester'] = $schedule->semester;
            $data['school_year'] = $schedule->school_year;
        }

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
