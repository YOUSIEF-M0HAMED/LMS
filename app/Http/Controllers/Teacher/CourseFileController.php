<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseFile;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Events\FileUploaded;

class CourseFileController extends Controller
{


  /**
   * Show the form for creating a new resource.
   */
  public function create(Course $course)
  {
    return view('teacher.courses.uploadFile', compact('course'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, Course $course)
  {
    $request->validate([
      'file_type' => 'required|in:video,image,other',
      'section' => 'required|in:content,assignment,quiz',
      'uploadedFile' => 'required|file',
    ]);


    $OriginalFileName = $request->file('uploadedFile')->getClientOriginalName(); // Get the original file name

    $file = $request->file('uploadedFile');
    $newFileName = time() . '.' . $file->getClientOriginalExtension();
    $path = 'courses/courses_files/';
    $file->move($path, $newFileName);

    $newCourseFile = CourseFile::create([
      'course_id' => $course->id,
      'file_name' => $OriginalFileName,
      'file_path' => $path . $newFileName,
      'file_type' => $request->file_type,
      'section' => $request->section,
    ]);

    event(new FileUploaded($newCourseFile));

    return redirect()->route('teacher.courses.show', $course->id)->with('success', 'File uploaded successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(CourseFile $courseFile)
  {
    $currentFile = $courseFile->file_path;
    $courseFile->delete();
    if ($currentFile && file_exists($currentFile)) {
      unlink($currentFile);
    }
    return redirect()->back()->with('success', 'CourseFile deleted successfully');
  }

  public function destroyAllCourseContent(course $course)
  {
    $courseFiles = $course->courseFiles->where('section', 'content');
    foreach ($courseFiles as $courseFile) {
      $currentFile = $courseFile->file_path;
      $courseFile->delete();
      if ($currentFile && file_exists($currentFile)) {
        unlink($currentFile);
      }
    }
    return redirect()->back()->with('success', 'All Uploaded Course Content  deleted successfully');
  }

  public function destroyAllCourseAssignments(course $course)
  {
    $courseFiles = $course->courseFiles->where('section', 'assignment');
    foreach ($courseFiles as $courseFile) {
      $currentFile = $courseFile->file_path;
      $courseFile->delete();
      if ($currentFile && file_exists($currentFile)) {
        unlink($currentFile);
      }
    }
    return redirect()->back()->with('success', 'All Uploaded Course Assignments  deleted successfully');
  }
}