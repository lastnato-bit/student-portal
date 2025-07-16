<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $student;

    public function mount()
    {
        $user = Auth::user();

        if ($user && $user->student) {
            $this->student = $user->student->load(['section', 'department', 'course']);
        }
    }

    public function render()
    {
        $user = Auth::user();
        $student = $user->student->load(['section', 'department', 'course']);

        return view('livewire.student.profile', [
            'user' => $user,
            'student' => $student,
        ]);
    }
}
