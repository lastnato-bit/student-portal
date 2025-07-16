<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\ClassSchedule;
use App\Models\Holiday;
use App\Models\AcademicPeriod;
use App\Models\Course;
use App\Models\Department;
use App\Models\Instructor;
use App\Models\Section;
use App\Models\Announcement;
use App\Models\EmailTemplate;

use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ArchiveCenter extends Page
{
    protected static string $view = 'filament.pages.archive-center';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'System Maintenance';
    protected static ?string $navigationLabel = 'Archive Center';

    public $archivedStudents;
    public $archivedSubjects;
    public $archivedGrades;
    public $archivedSchedules;
    public $archivedHolidays;
    public $archivedPeriods;
    public $archivedCourses;
    public $archivedDepartments;
    public $archivedInstructors;
    public $archivedSections;
    public $archivedAnnouncements;
    public $archivedEmails;
    public $archivedAdminUsers;

    public function mount(): void
    {
        $this->archivedStudents = Student::onlyTrashed()->with('user')->get();
        $this->archivedSubjects = Subject::onlyTrashed()->get();
        $this->archivedGrades = Grade::onlyTrashed()->get();
        $this->archivedSchedules = ClassSchedule::onlyTrashed()->get();
        $this->archivedHolidays = Holiday::onlyTrashed()->get();
        $this->archivedPeriods = AcademicPeriod::onlyTrashed()->get();
        $this->archivedCourses = Course::onlyTrashed()->get();
        $this->archivedDepartments = Department::onlyTrashed()->get();
        $this->archivedInstructors = Instructor::onlyTrashed()->get();
        $this->archivedSections = Section::onlyTrashed()->get();
        $this->archivedAnnouncements = Announcement::onlyTrashed()->get();
        $this->archivedEmails = EmailTemplate::onlyTrashed()->get();

        // Only users with 'admin' role
        $this->archivedAdminUsers = User::onlyTrashed()
            ->whereHas('roles', fn ($q) => $q->where('name', 'admin'))
            ->get();
    }

    public function restoreRecord(string $model, int $id): void
    {
        $allowedModels = [
            'Student' => Student::class,
            'Subject' => Subject::class,
            'Grade' => Grade::class,
            'ClassSchedule' => ClassSchedule::class,
            'Holiday' => Holiday::class,
            'AcademicPeriod' => AcademicPeriod::class,
            'Course' => Course::class,
            'Department' => Department::class,
            'Instructor' => Instructor::class,
            'Section' => Section::class,
            'Announcement' => Announcement::class,
            'User' => User::class, // Admin User
        ];

        if (!array_key_exists($model, $allowedModels)) {
            abort(403, 'Unauthorized model.');
        }

        $record = $allowedModels[$model]::onlyTrashed()->findOrFail($id);

        // Optional: for Admin User, check if user really has admin role
        if ($model === 'User' && !$record->hasRole('admin')) {
            abort(403, 'Only Admin users are restorable here.');
        }

        $record->restore();

        $this->mount(); // Refresh

        Notification::make()
            ->title('Restored')
            ->body("$model restored successfully.")
            ->success()
            ->send();
    }
}
