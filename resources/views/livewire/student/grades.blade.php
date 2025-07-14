<div class="p-4">
    <h1 class="text-xl font-bold mb-4">📊 My Grades</h1>

    @if ($grades->isEmpty())
        <p>No grades available yet.</p>
    @else
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Subject</th>
                    <th class="px-4 py-2">Instructor</th>
                    <th class="px-4 py-2">Semester</th>
                    <th class="px-4 py-2">School Year</th>
                    <th class="px-4 py-2">Grade</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @foreach ($grades as $grade)
                    <tr>
                        <td class="px-4 py-2">
                            {{ $grade->classSchedule?->subject?->name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $grade->classSchedule?->instructor?->full_name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2">{{ $grade->semester }}</td>
                        <td class="px-4 py-2">{{ $grade->school_year }}</td>
                        <td class="px-4 py-2">{{ $grade->grade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
