<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ClassSchedule;

class EnrollmentInfo extends Component
{
    public $student;
    public $schedules;
    public $schoolYear = 'N/A';
    public $semester = 'N/A';

    public function mount()
    {
        $this->student = Student::with(['section', 'department'])
            ->where('user_id', Auth::id())
            ->first();

        if ($this->student && $this->student->section_id) {
            $this->schedules = ClassSchedule::where('section_id', $this->student->section_id)->get();

            if ($this->schedules->isNotEmpty()) {
                $first = $this->schedules->first();
                $this->schoolYear = $first->school_year ?? 'N/A';
                $this->semester = $first->semester ?? 'N/A';
            }
        } else {
            $this->schedules = collect(); // fallback if no section
        }
    }

    public function render()
    {
        return view('livewire.student.enrollment-info', [
            'student' => $this->student,
            'schedules' => $this->schedules,
            'schoolYear' => $this->schoolYear,
            'semester' => $this->semester,
        ]);
    }
}
