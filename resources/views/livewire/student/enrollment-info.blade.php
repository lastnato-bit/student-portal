<div class="space-y-6">
    <h2 class="text-2xl font-bold">🧾 Enrollment Information</h2>

    @if(isset($student) && $student)
        <!-- 👤 Student Profile -->
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold mb-4">👤 Student Profile</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><strong>Name:</strong> {{ $student->user->full_name ?? 'N/A' }}</div>
                <div><strong>Student Number:</strong> {{ $student->student_number ?? 'N/A' }}</div>
                <div><strong>Gender:</strong> {{ $student->gender ?? 'N/A' }}</div>
                <div><strong>Birthdate:</strong> {{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->toFormattedDateString() : 'N/A' }}</div>
                <div><strong>Contact Number:</strong> {{ $student->contact_number ?? 'N/A' }}</div>
                <div><strong>Email:</strong> {{ $student->user->email ?? 'N/A' }}</div>
                <div><strong>Address:</strong> {{ $student->address ?? 'N/A' }}</div>
                <div><strong>Department:</strong> {{ $student->department->name ?? 'N/A' }}</div>
                <div><strong>Course:</strong> {{ $student->course?->name ?? 'N/A' }}</div>
                <div><strong>Year Level:</strong> {{ $student->year_level ?? 'N/A' }}</div>
                <div><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- 📌 Enrollment Info -->
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold mb-4">📌 Enrollment Details</h3>
            <p><strong>School Year:</strong> {{ $schoolYear ?? 'N/A' }}</p>
            <p><strong>Semester:</strong> {{ ucfirst($semester ?? 'N/A') }}</p>
            <p><strong>Status:</strong> {{ $student->enrollment_status ?? 'Enrolled' }}</p>
        </div>

        <!-- 🗓️ Class Schedule -->
        <div class="bg-white shadow-md rounded p-6">
            <h3 class="text-lg font-semibold mb-4">🗓️ Class Schedule</h3>

            @if(isset($schedules) && $schedules->isNotEmpty())
                <table class="w-full text-sm table-auto border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border text-left">Subject</th>
                            <th class="px-3 py-2 border text-left">Day</th>
                            <th class="px-3 py-2 border text-left">Time</th>
                            <th class="px-3 py-2 border text-left">Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td class="px-3 py-2 border">
                                    {{ $schedule->subject->code ?? 'N/A' }} - {{ $schedule->subject->name ?? '' }}
                                </td>
                                <td class="px-3 py-2 border capitalize">{{ $schedule->day ?? 'N/A' }}</td>
                                <td class="px-3 py-2 border">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                </td>
                                <td class="px-3 py-2 border">{{ $schedule->room ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No class schedule assigned yet.</p>
            @endif
        </div>
    @else
        <p class="text-red-600">Student information not available.</p>
    @endif
</div>
