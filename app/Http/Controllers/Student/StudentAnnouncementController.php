
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class StudentAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('is_visible', true)
            ->latest()
            ->paginate(10);

        return view('student.announcements.index', compact('announcements'));
    }
}
