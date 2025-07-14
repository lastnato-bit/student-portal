<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">My Schedule</h1>

    @if($schedules->isEmpty())
        <p>No schedule assigned to your section.</p>
    @else
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Subject</th>
                    <th class="px-4 py-2 border">Instructor</th>
                    <th class="px-4 py-2 border">Day</th>
                    <th class="px-4 py-2 border">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td class="px-4 py-2 border">{{ $schedule->subject?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $schedule->instructor?->full_name ?? 'TBA' }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($schedule->day) }}</td>
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                            -
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
