<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;

class AdminCalendarController extends Controller
{
    public function showForm()
    {
        return view('admin.calendar.create');
    }

    public function store(Request $request, GoogleCalendarService $calendarService)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $calendarService->createEvent(
            $request->title,
            $request->description,
            $request->start,
            $request->end
        );

        return redirect()->back()->with('success', 'Event synced to Google Calendar!');
    }
}
