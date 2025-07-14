<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GradeController extends Controller
{
    public function download()
    {
        $student = Auth::user()->student; // ✅ get the Student model

        $grades = $student->grades()->with('classSchedule')->get(); // ✅ from Student model

        $pdf = Pdf::loadView('student.pdf.grades', compact('student', 'grades'));

        return $pdf->download('grade-report.pdf');
    }
}
