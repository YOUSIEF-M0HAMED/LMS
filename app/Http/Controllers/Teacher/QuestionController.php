<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(string $quiz_id)
  {
    $questions = Question::where('quiz_id', $quiz_id)->get();
    return view('teacher.question.index', ['questions' => $questions, 'quiz_id' => $quiz_id]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(string $quiz_id)
  {
    return view('teacher.question.create', ['quiz_id' => $quiz_id]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Question $question)
  {
    request()->validate([
      'question' => 'required',
      'option_a' => 'required',
      'option_b' => 'required',
      'option_c' => 'required',
      'option_d' => 'required',
      'correct_option' => 'required',
    ], [
      'correct_option.required' => 'Please select an option.',
    ]);
    $question->create([
      'question' => request()->question,
      'option_a' => request()->option_a,
      'option_b' => request()->option_b,
      'option_c' => request()->option_c,
      'option_d' => request()->option_d,
      'correct_option' => request()->correct_option,
      'quiz_id' => request()->quiz_id,
    ]);
    return redirect()->route('teacher.question.index', request()->quiz_id)->with('success', 'Question is created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Question $question)
  {
    return view('teacher.question.edit', ['question' => $question]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Question $question)
  {
    request()->validate([
      'question' => 'required',
      'option_a' => 'required',
      'option_b' => 'required',
      'option_c' => 'required',
      'option_d' => 'required',
      'correct_option' => 'required',
    ], [
      'correct_option.required' => 'Please select an option.',
    ]);
    $question->update([
      'question' => request()->question,
      'option_a' => request()->option_a,
      'option_b' => request()->option_b,
      'option_c' => request()->option_c,
      'option_d' => request()->option_d,
      'correct_option' => request()->correct_option,
    ]);
    return redirect()->route('teacher.question.index', $question->quiz_id)->with('success', 'Question is updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Question $question)
  {
    $question->delete();
    return redirect()->route('teacher.question.index', $question->quiz_id)->with('success', 'Question is deleted successfully!');
  }
}
