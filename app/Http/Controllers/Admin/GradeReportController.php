<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Ensure correct import

class GradeReportController extends Controller
{
    public function export(Student $student)
    {
        // ✅ Check if the 'grades' relationship exists in Student model
        $grades = $student->grades;

        // ✅ Make sure 'admin.reports.grade' Blade view exists and is correct
        $pdf = Pdf::loadView('admin.reports.grade', [
            'student' => $student,
            'grades' => $grades,
        ]);

        return $pdf->download($student->name . '_grade_report.pdf');
    }
}
