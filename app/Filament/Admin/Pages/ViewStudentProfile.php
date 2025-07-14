<?php
namespace App\Filament\Pages\Admin;

use Filament\Pages\Page;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ViewStudentProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Student Records';
    protected static ?string $title = 'Student Profile Viewer';
    protected static string $view = 'filament.pages.admin.view-student-profile';

    public $students;

    public function mount(): void
    {
        $this->students = Student::with(['grades', 'section', 'department'])
            ->when(Auth::user()->hasRole('admin'), fn($q) => $q->where('department_id', Auth::user()->department_id))
            ->get();
    }
}
