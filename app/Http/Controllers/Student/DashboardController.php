<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;
use App\Models\Announcement;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $announcements;
    public $classSchedules;

    public function mount()
    {
        $user = Auth::user();
        $sectionId = $user->section_id;

        $this->announcements = Announcement::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $this->classSchedules = $sectionId
            ? ClassSchedule::where('section_id', $sectionId)->get()
            : collect();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
