<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = ClassSchedule::with('student') // eager load relationship if needed
            ->where('student_id', Auth::id())
            ->orderBy('day')
            ->orderBy('start_time')
            ->orderBy('end_time')
            ->get();

        return Inertia::render('Student/Schedule', [
            'schedules' => $schedules,
        ]);
    }
}
