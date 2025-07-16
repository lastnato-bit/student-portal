<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Concern;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class Concerns extends Component
{
    public $message;
    public $category;

    public function submit()
    {
        $this->validate([
            'category' => 'required|string|in:Schedule,Grades,Enrollment,Profile,Others',
            'message' => 'required|string|min:10',
        ]);

        $user = Auth::user();
        $student = $user->student ?? Student::where('user_id', $user->id)->first();

        if (!$student) {
            session()->flash('error', 'Student record not found. Please contact the registrar.');
            return;
        }

        Concern::create([
            'student_id' => $student->id,
            'category' => $this->category,
            'message' => $this->message,
            'status' => 'Pending',
        ]);

        session()->flash('success', '✅ Your concern has been submitted successfully.');
        $this->reset(['category', 'message']);
    }

    public function render()
    {
        $user = Auth::user();
        $student = $user->student ?? Student::where('user_id', $user->id)->first();

        $concerns = $student
            ? Concern::where('student_id', $student->id)->latest()->get()
            : [];

        return view('livewire.student.concerns', compact('concerns'));
    }
}
