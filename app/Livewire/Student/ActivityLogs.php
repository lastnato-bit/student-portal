<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogs extends Component
{
    public $logs;

    public function mount()
    {
        $this->logs = Activity::where('causer_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(20)
            ->get();
    }

    public function render()
    {
        return view('livewire.student.activity-logs');
    }
}
