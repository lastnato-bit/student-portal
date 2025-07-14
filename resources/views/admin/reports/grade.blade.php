<!DOCTYPE html>
<html>
<head>
    <title>Grade Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Grade Report - {{ $student->name }}</h2>
    <p>Email: {{ $student->email }}</p>
    <p>Student Number: {{ $student->student_number }}</p>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Semester</th>
                <th>School Year</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr>
                    <td>{{ $grade->subject }}</td>
                    <td>{{ $grade->semester }}</td>
                    <td>{{ $grade->school_year }}</td>
                    <td>{{ $grade->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
