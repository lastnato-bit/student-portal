<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Show the form to create a holiday
     */
    public function create()
    {
        return view('holidays.create');
    }

    /**
     * Store a holiday and sync it to Google Calendar
     */
    public function store(Request $request, GoogleCalendarService $calendarService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        // Save to the local database
        $holiday = Holiday::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'date' => $validated['date'],
        ]);

        // Sync to Google Calendar
        try {
            $calendarService->createEvent(
                $holiday->title,
                $holiday->description,
                $holiday->date . ' 00:00:00',
                $holiday->date . ' 23:59:59'
            );
        } catch (\Exception $e) {
            // Optionally handle Google Calendar failure
            return redirect()->back()->with('error', 'Holiday saved but failed to add to Google Calendar: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Holiday saved and added to Google Calendar.');
    }
}
