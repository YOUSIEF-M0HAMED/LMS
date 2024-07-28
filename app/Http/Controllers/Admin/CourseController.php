<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Exports\CoursesExport;
use App\Imports\CoursesImport;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Maatwebsite\Excel\Facades\Excel;


class CourseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $courses = Course::all();
    return view('admin.administration.courses.index', ['courses' => $courses]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $teachers = Teacher::all();
    return view('admin.administration.courses.create', compact('teachers'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, CourseRequest $courseRequest)
  {

    $logo = null;
    if ($request->has('logo')) {
      $file = $request->file('logo');
      $extension = $file->getClientOriginalExtension();
      $path = 'courses/';
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $logo = $path . $filename;
    }

    Course::create([
      'teacher_id' => $request->teacher_id,
      'course_code' => $request->course_code,
      'name' => $request->name,
      'specification' => $request->specification,
      'logo' => $logo,
    ]);
    return redirect()->route('admin.course.index')->with('success', 'Course created successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Course $course)
  {
    $courseContentFiles = $course->courseFiles->where('section', 'content')->all();
    $courseAssignmentFiles = $course->courseFiles->where('section', 'assignment')->all();
    return view('admin.administration.courses.show', compact('course', 'courseContentFiles', 'courseAssignmentFiles'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Course $course)
  {
    $teachers = Teacher::all();
    return view('admin.administration.courses.edit', compact('course', 'teachers'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Course $course)
  {
    $request->validate([
      'course_code' => [
        'required',
        Rule::unique('courses', 'course_code')->ignore($course->id),
      ],
      'name' => 'required',
      'logo' => 'max:4096',
    ]);
    $currentLogo = $course->logo;
    $logo = $currentLogo;
    if ($request->has('logo')) {
      $file = $request->file('logo');
      $extension = $file->getClientOriginalExtension();
      $path = 'courses/';
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $logo = $path . $filename;

      if ($currentLogo && file_exists($currentLogo)) {
        unlink($currentLogo);
      }
    }

    $course->update([
      'teacher_id' => $request->teacher_id,
      'course_code' => $request->course_code,
      'name' => $request->name,
      'specification' => $request->specification,
      'logo' => $logo,
    ]);
    return redirect()->route('admin.course.index')->with('success', 'Course updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Course $course)
  {
    $course->delete();
    return redirect()->back()->with('success', 'Course deleted successfully');
  }


  public function import()
  {
    request()->validate([
      'file' => 'required',
    ]);
    Excel::import(new CoursesImport, request()->file('file'));
    return redirect()->back()->with('success', 'Courses imported successfully');
  }

  public function export()
  {
    return Excel::download(new CoursesExport, 'courses.xlsx');
  }
}
