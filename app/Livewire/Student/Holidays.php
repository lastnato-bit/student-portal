<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Holiday;

class Holidays extends Component
{
    public $holidays = [];

    public function mount()
{
    $apiHolidays = [];
    try {
        $response = Http::timeout(5)->get('https://date.nager.at/api/v3/PublicHolidays/2024/US');

        if ($response->successful()) {
            $apiHolidays = collect($response->json())->map(function ($holiday) {
                return [
                    'title' => $holiday['name'] ?? 'No title',
                    'description' => $holiday['localName'] ?? 'No description',
                    'date' => $holiday['date'] ?? null,
                ];
            });
        }
    } catch (\Exception $e) {
        Log::error('Holiday API connection failed: ' . $e->getMessage());
    }

    $localHolidays = collect(Holiday::select('title', 'description', 'date')->get());

    // Combine, then remove duplicates based on title + date
    $this->holidays = $localHolidays
        ->merge($apiHolidays)
        ->unique(fn ($item) => $item['title'] . $item['date'])  // removes dupes
        ->sortBy('date')
        ->values()
        ->toArray();
}


    public function render()
    {
        return view('livewire.student.holidays')
            ->layout('layouts.app');
    }
}
