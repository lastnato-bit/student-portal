<?php

namespace App\Livewire\Student;

use Livewire\Component;

class GradeReport extends Component
{
    public function render()
    {
        return view('livewire.student.grade-report')
        ->layout('layouts.app');
    }
}
