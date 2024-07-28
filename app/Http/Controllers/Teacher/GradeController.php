<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\StudentsQuizExport;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
{
  public function show(string $quizId)
  {
    // Fetch all students and their grades for the specified quiz
    $students = Student::with(['studentQuizzes' => function ($query) use ($quizId) {
      $query->where('quiz_id', $quizId);
    }])->get();
    return view('teacher.grade.show', compact('students', 'quizId'));
  }

  public function export($quizId)
  {
    return Excel::download(new StudentsQuizExport($quizId), 'students_quiz_scores.xlsx');
  }
}
