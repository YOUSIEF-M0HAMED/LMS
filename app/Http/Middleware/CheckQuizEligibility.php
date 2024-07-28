<?php

namespace App\Http\Middleware;

use App\Models\Quiz;
use App\Models\StudentQuiz;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckQuizEligibility
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $quiz_id = $request->route('quiz_id');
    $quiz = Quiz::where('id', $quiz_id)->first();

    $studentQuiz = StudentQuiz::where('student_id', Auth::guard('student')->id())->where('quiz_id', $quiz->id)->first();
    $currentTime = now();


    if ($studentQuiz) {
      return redirect()->back()->with('error', 'You have already taken this quiz.');
    }

    if ($currentTime < $quiz->from_time || $currentTime > $quiz->to_time) {
      return redirect()->back()->with('error', 'This quiz is not available at the moment.');
    }

    return $next($request);
  }
}
