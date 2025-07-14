<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SectionSchedule extends Component
{
    public $schedules;

    public function mount()
    {
        $user = Auth::user();

        if (!$user->section) {
            $this->schedules = collect();
        } else {
            $this->schedules = $user->section->schedules()
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.student.section-schedule')
            ->layout('layouts.app');
    }
}
