<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Activity::where('causer_id', $request->user()->id)
            ->latest()
            ->take(50)
            ->get();

        return Inertia::render('Student/ActivityLogs', [
            'logs' => $logs
        ]);
    }
}
