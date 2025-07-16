<?php

namespace App\Filament\Pages\Admin;

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
// use App\Models\EmailTemplate; // Uncomment only if `deleted_at` is added in migration

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

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
    // public $archivedEmails; // Email template soft deletes must exist
    public $archivedAdminUsers;

    public function mount(): void
    {
        $admin = Auth::user();

        if (!$admin->hasRole('admin')) {
            abort(403, 'Unauthorized.');
        }

        $departmentId = $admin->department_id;

        $this->archivedStudents = Student::onlyTrashed()
            ->where('department_id', $departmentId)
            ->with('user')
            ->get();

        $this->archivedSubjects = Subject::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedGrades = Grade::onlyTrashed()
            ->whereHas('student', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->get();

        $this->archivedSchedules = ClassSchedule::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedHolidays = Holiday::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedPeriods = AcademicPeriod::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedCourses = Course::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedDepartments = Department::onlyTrashed()
            ->where('id', $departmentId)
            ->get();

        $this->archivedInstructors = Instructor::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedSections = Section::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        $this->archivedAnnouncements = Announcement::onlyTrashed()
            ->where('department_id', $departmentId)
            ->get();

        // $this->archivedEmails = EmailTemplate::onlyTrashed()->get(); // Only if model supports soft deletes

        // Admins can only restore Admin-level users from their own department
        $this->archivedAdminUsers = User::onlyTrashed()
            ->where('department_id', $departmentId)
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
            'User' => User::class, // Admin User only
            // 'EmailTemplate' => EmailTemplate::class, // Optional
        ];

        if (!array_key_exists($model, $allowedModels)) {
            abort(403, 'Unauthorized model.');
        }

        $record = $allowedModels[$model]::onlyTrashed()->findOrFail($id);

        // Restrict Admin from restoring Superadmin or records not in their department
        $admin = Auth::user();
        $departmentId = $admin->department_id;

        if ($model === 'User') {
            if (!$record->hasRole('admin') || $record->department_id !== $departmentId) {
                abort(403, 'Only Admin users from your department can be restored.');
            }
        } elseif (in_array('department_id', $record->getFillable()) && $record->department_id !== $departmentId) {
            abort(403, 'You cannot restore records outside your department.');
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
