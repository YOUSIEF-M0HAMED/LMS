<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $students = Student::all();
    $courses = Course::all();
    return view('admin.administration.course_student.index', compact('students', 'courses'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $allStudents = Student::all();
    $allCourses = Course::all();
    return view('admin.administration.course_student.create', compact('allStudents', 'allCourses'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'student_id' => 'required|exists:students,id',
      'course_id' => 'required|exists:courses,id|unique:course_student,course_id,null,id,student_id,' . $request->student_id,
    ]);
    $student = Student::find($request->student_id);
    $student->courses()->attach($request->course_id);
    return redirect()->route('admin.course_student.index')->with('success', 'Operation is created successfully!');
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
  public function edit($student_id, $course_id)
  {
    $student = Student::find($student_id);
    $allCourses = Course::all();
    $course = Course::find($course_id);
    return view('admin.administration.course_student.edit', compact('student', 'allCourses', 'course'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $student_id, $course_id)
  {
    $request->validate([
      'new_course_id' => 'required|exists:courses,id|unique:course_student,course_id,null,id,student_id,' . $student_id,
    ]);
    $student = Student::find($student_id);
    // $course = Course::find($course_id);
    $student->courses()->detach($course_id);
    if ($request->has('new_course_id')) {
      $student->courses()->attach($request->new_course_id);
    }
    return redirect()->route('admin.course_student.index')->with('success', 'Operation is updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($student_id, $course_id)
  {
    $student = Student::find($student_id);
    $student->courses()->detach($course_id);
    return redirect()->route('admin.course_student.index')->with('success', 'Operation is deleted successfully!');
  }
}
