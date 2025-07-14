<x-filament::page>
    <h2 class="text-xl font-bold mb-4">Student Profiles</h2>

    <div class="space-y-6">
        @foreach ($students as $student)
            <x-filament::card>
                <div class="text-lg font-semibold">{{ $student->name }} ({{ $student->student_number }})</div>
                <div>Email: {{ $student->email }}</div>
                <div>Department: {{ $student->department->name ?? 'N/A' }}</div>
                <div>Section: {{ $student->section->name ?? 'N/A' }}</div>

                <div class="mt-4">
                    <h3 class="font-medium">Grades:</h3>
                    <ul class="list-disc ml-6">
                        @forelse ($student->grades as $grade)
                            <li>{{ $grade->subject }} - {{ $grade->grade }} ({{ $grade->semester }}, {{ $grade->school_year }})</li>
                        @empty
                            <li>No grades available</li>
                        @endforelse
                    </ul>
                </div>
            </x-filament::card>
        @endforeach
    </div>
</x-filament::page>
