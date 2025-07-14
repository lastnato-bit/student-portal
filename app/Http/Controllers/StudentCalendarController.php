<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;

class StudentCalendarController extends Controller
{
    public function index(GoogleCalendarService $calendarService)
    {
        $events = $calendarService->listEvents();
        return view('student.calendar.index', compact('events'));
    }
}
