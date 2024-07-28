<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseFile;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $currentTeacher = Auth::guard('teacher')->user();
    $courses = $currentTeacher->courses;
    return view('teacher.courses.index', ['courses' => $courses]);
  }


  /**
   * Display the specified resource.
   */
  public function show(Course $course)
  {
    $courseContentFiles = $course->courseFiles->where('section', 'content')->all();
    $courseAssignmentFiles = $course->courseFiles->where('section', 'assignment')->all();
    $courseQuizzes = $course->quizzes;
    return view(
      'teacher.courses.show',
      compact('course', 'courseContentFiles', 'courseAssignmentFiles', 'courseQuizzes')
    );
  }
}
