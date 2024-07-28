<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\StudentQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

  public function showQuiz(string $quiz_id)
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    $questions = Question::where('quiz_id', $quiz_id)->get();
    return view('student.test.show', compact('questions', 'quiz_id','notifications'));
  }

  public function store(Request $request, string $quiz_id)
  {
    $studentId = Auth::guard('student')->id();
    $data = $request->all();
    foreach ($data as $key => $value) {
      if (strpos($key, 'correct_option') !== false) {
        $questionId = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
        $question = Question::find($questionId);
        if ($question) {
          StudentAnswer::create([
            'student_id' => $studentId,
            'question_id' => $questionId,
            'selected_option' => $value,
          ]);
        }
      }
    }
    return redirect()->route('student.test.grade', $quiz_id)->with('success', 'The answer is submitted successfully');
  }

  public function grade(Request $request, string $quiz_id)
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    $studentId = Auth::guard('student')->id();
    $answers = StudentAnswer::where('student_id', $studentId)
      ->whereHas('question', function ($query) use ($quiz_id) {
        $query->where('quiz_id', $quiz_id);
      })
      ->get();
    $score = 0;
    foreach ($answers as $answer) {
      $question = $answer->question;
      if ($answer->selected_option === $question->correct_option) {
        $score++;
      }
    }
    StudentQuiz::create([
      'student_id' => Auth::guard('student')->id(),
      'quiz_id' => $quiz_id,
      'score' => $score,
      'taken_at' => now(),
    ]);
    return view('student.test.result', compact('score','notifications'));
  }
}