<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GradeReportController extends Controller
{
    public function export()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(404, 'Student record not found.');
        }

        $grades = $student->grades()->with('subject')->get();

        $pdf = Pdf::loadView('pdf.student-grade-report', [
            'student' => $student,
            'grades' => $grades,
        ]);

        return $pdf->download('grade-report.pdf');
    }
}
