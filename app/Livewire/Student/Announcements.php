<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Announcement;

class Announcements extends Component
{
    public function render()
    {
        $announcements = Announcement::whereIn('visible_to', ['student', 'all'])
            ->orderByDesc('published_at')
            ->get();

        return view('student.announcements', [
            'announcements' => $announcements,
        ]);
    }
}
