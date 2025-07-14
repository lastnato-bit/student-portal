<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class Grades extends Component
{
    public $grades;

    public function mount()
    {
        $this->grades = Grade::where('student_id', Auth::id())->get();
    }

   public function render()
{
    $student = \App\Models\Student::where('user_id', Auth::id())->first();

    $grades = $student
        ? \App\Models\Grade::where('student_id', $student->id)->get()
        : collect(); // Return empty if not found

    return view('livewire.student.grades')
    ->layout('layouts.app'); // This is the default Jetstream layout

}

}