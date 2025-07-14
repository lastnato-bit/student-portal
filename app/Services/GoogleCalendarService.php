<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Carbon;

class GoogleCalendarService
{
    protected $service;
    protected $calendarId;

    public function __construct()
    {
        // Get calendar ID from .env via config/services.php
        $this->calendarId = config('services.google_calendar.calendar_id');

        // Create a Google Client and load credentials using absolute path
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/google-calendar-service-account.json')); // ✅ fixed path
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');

        // Initialize calendar service
        $this->service = new Google_Service_Calendar($client);
    }

    public function createEvent($title, $description, $startDateTime, $endDateTime)
    {
        $event = new Google_Service_Calendar_Event([
            'summary' => $title,
            'description' => $description,
            'start' => [
                'dateTime' => Carbon::parse($startDateTime)->toRfc3339String(),
                'timeZone' => 'Asia/Manila',
            ],
            'end' => [
                'dateTime' => Carbon::parse($endDateTime)->toRfc3339String(),
                'timeZone' => 'Asia/Manila',
            ],
        ]);

        return $this->service->events->insert($this->calendarId, $event);
    }

    public function listEvents($maxResults = 10)
    {
        $params = [
            'maxResults' => $maxResults,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => Carbon::now()->toRfc3339String(),
        ];

        return $this->service->events->listEvents($this->calendarId, $params)->getItems();
    }
}
