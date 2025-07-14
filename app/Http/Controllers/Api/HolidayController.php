<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class HolidayController
{
    public function index()
    {
        // Cache for 24 hours
        $holidays = Cache::remember('philippine_holidays_2025', 60 * 24, function () {
            $response = Http::get('https://date.nager.at/api/v3/PublicHolidays/2025/PH');
            
            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });

        return Inertia::render('Student/Holidays', [
            'holidays' => $holidays,
        ]);
    }
}

