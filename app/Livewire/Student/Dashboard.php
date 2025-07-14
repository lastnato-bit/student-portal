<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $student = Student::with(['user', 'department', 'section'])
            ->where('user_id', Auth::id())
            ->first();

        $schedules = collect();
        $schoolYear = 'N/A';
        $semester = 'N/A';

        if ($student && $student->section_id) {
            $schedules = ClassSchedule::where('section_id', $student->section_id)->get();

            if ($schedules->isNotEmpty()) {
                $first = $schedules->first();

                $schoolYear = trim((string) $first->school_year) ?: 'N/A';
                $semester = trim((string) $first->semester) ?: 'N/A';
            }
        }

        return view('livewire.student.dashboard', [
            'student' => $student,
            'schedules' => $schedules,
            'schoolYear' => $schoolYear,
            'semester' => $semester,
        ]);
    }
}
