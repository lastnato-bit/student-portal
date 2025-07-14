<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSchedule;

class Schedule extends Component
{
    public $schedules;

    public function mount()
    {
        $user = Auth::user();

        if ($user && $user->student) {
            $student = $user->student;

            // ✅ Assuming ClassSchedule is filtered by section
            $this->schedules = ClassSchedule::where('section_id', $student->section_id)->get();
        } else {
            $this->schedules = collect(); // return empty collection
        }
    }

    public function render()
    {
        return view('livewire.student.schedule');
    }
}
