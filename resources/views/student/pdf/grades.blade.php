<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Grade Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Grade Report - {{ $student->name }}</h2>
    <p><strong>Email:</strong> {{ $student->email }}</p>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Instructor</th>
                <th>Semester</th>
                <th>School Year</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
                <tr>
                    <td>{{ $grade->subject ?? $grade->classSchedule->subject ?? 'N/A' }}</td>
                    <td>{{ $grade->classSchedule->instructor_name ?? 'N/A' }}</td>
                    <td>{{ $grade->semester ?? $grade->classSchedule->semester ?? 'N/A' }}</td>
                    <td>{{ $grade->school_year ?? $grade->classSchedule->school_year ?? 'N/A' }}</td>
                    <td>{{ $grade->grade ?? 'N/A' }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="5">No grades found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
