<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizGradeController extends Controller
{
  public function showQuizzes()
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    // Assuming the student is authenticated
    $student = Auth::guard('student')->user();

    // Get all quizzes for the student's courses
    $quizzes = Quiz::whereHas('course', function ($query) use ($student) {
      $query->whereHas('students', function ($query) use ($student) {
        $query->where('course_student.student_id', $student->id);
      });
    })->get();
    return view('student.quiz.showQuizzes', compact('quizzes','notifications'));
  }

  public function showGrades()
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    // Assuming the student is authenticated
    $student = Auth::guard('student')->user();
    // Fetch grades for the student
    $grades = StudentQuiz::where('student_id', $student->id)->get();
    return view('student.quiz.showGrades', compact('grades','notifications'));
  }
}