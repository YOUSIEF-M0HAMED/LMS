<?php

namespace App\Http\Controllers\Teacher;

use App\Events\QuizAdded;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $quizzes = Quiz::all();
    return view('teacher.quiz.index', ['quizzes' => $quizzes]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('teacher.quiz.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validatedQuiz = $request->validate([
      'title' => 'required',
      'course_id' => 'required',
      'from_time' => 'required',
      'to_time' => 'required',
      'duration' => 'required|numeric|min:1',
    ]);
    $quiz = Quiz::create($validatedQuiz);

    event(new QuizAdded ($quiz));

    return redirect()->route('teacher.quiz.index')->with('success', 'Quiz is created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Quiz $quiz)
  {
    return redirect()->route('teacher.question.index', $quiz->id);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Quiz $quiz)
  {
    return view('teacher.quiz.edit', ['quiz' => $quiz]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Quiz $quiz)
  {
    request()->validate([
      'title' => 'required',
      'course_id' => 'required',
      'from_time' => 'required',
      'to_time' => 'required',
      'duration' => 'required|numeric|min:1',
    ]);
    $quiz->update([
      'title' => request()->title,
      'course_id' => request()->course_id,
      'from_time' => request()->from_time,
      'to_time' => request()->to_time,
      'duration' => request()->duration,
    ]);
    return redirect()->route('teacher.quiz.index')->with('success', 'Quiz is updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Quiz $quiz)
  {
    $quiz->delete();
    return redirect()->route('teacher.quiz.index')->with('success', 'Quiz is deleted successfully!');
  }
}