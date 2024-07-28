<?php

namespace App\Http\Controllers\Teacher;
use App\Models\Student;
use App\Models\Teacher;

use App\Models\Quiz;
use App\Models\CourseStudent;
use App\Rules\uniqueEmail;
use App\Rules\uniqueUserId;
use Illuminate\Http\Request;
use App\Rules\uniqueUsername;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// yousef
use App\Models\Course;
use App\Models\CourseFile;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;


class TeacherController extends Controller
{

  public function home()
  {
    $numberOfStudents= 0 ;
    // $totalQuizzes = 0 ;
    $teacher = Teacher::findOrFail($teacherid = Auth::guard('teacher')->user()->id);

// Eager load courses with students count
$teacherCourses = $teacher->courses()->withCount('students')->get();
// $teacherQuzzies = $teacher->courses()->withCount('quizzes')->get();

// foreach ($teacherCourses as $course ) {
//     $numberOfStudents += $course->students_count;
//     $courseName =$course->name;
    
// }
// foreach ($teacherQuzzies as $quiz ) {
  
//   $totalQuizzes += $quiz->quizzes_count;
  // $upcomingQuizzes += $quiz->where(cours('quizzes')->get(), '>', now())->count();
// }
// Use $numberOfStudents as needed, e.g., to display in a view

// $numberOfStudents = Course::where('teacher_id',Auth::guard('teacher')->user()->id)->withCount('students')->get();
// $numberOfStudents = ($numberOfStudents > 0) ? $numberOfStudents : 0;
$completedQuizzes = Quiz::whereHas('course', function ($query) use ($teacher) {
  $query->where('teacher_id', $teacher->id);
})->where('to_time', '<', now())->count();

$upcomingQuizzes = Quiz::whereHas('course', function ($query) use ($teacher) {
  $query->where('teacher_id', $teacher->id);
})->where('from_time', '>', now())->count();

$activeQuizzes = Quiz::whereHas('course', function ($query) use ($teacher) {
  $query->where('teacher_id', $teacher->id);
})->where('from_time', '<=', now())->where('to_time', '>=', now())->count();

$totalQuizzes = $completedQuizzes + $activeQuizzes + $upcomingQuizzes;
    // $completedPercentage = $totalQuizzes > 0 ? ($completedQuizzes / $totalQuizzes) * 100 : 0;
    // $upcomingPercentage = $totalQuizzes > 0 ? ($upcomingQuizzes / $totalQuizzes) * 100 : 0;
    // $activePercentage = $totalQuizzes > 0 ? ($activeQuizzes / $totalQuizzes) * 100 : 0;
     $numberOfCourses = Course::where('teacher_id',Auth::guard('teacher')->user()->id)->count();
    $current_teacher = Auth::guard('teacher')->user();
    $courses = $current_teacher->courses;
    
    
    return view('teacher.home', [
      'numberOfCourses' => $numberOfCourses,
     'numberOfStudents' => $numberOfStudents,
      'totalQuizzes'=> $totalQuizzes,
      'upcomingQuizzes'=> $upcomingQuizzes ,
      'completedQuizzes'=> $completedQuizzes,
      'activeQuizzes'=> $activeQuizzes,
      // 'completedPercentage'=> $completedPercentage,
      // 'activePercentage'=> $activePercentage,
      // 'upcomingPercentage'=> $upcomingPercentage,
     'teacherCourses'  => $teacherCourses,
     'courses' => $courses,

    ]);

  }
  public function showProfile()
  {
    $current_teacher = Auth::guard('teacher')->user();
    return view('teacher.data.profile', ['current_teacher' => $current_teacher]);
  }

  public function showConfirmPasswordForm()
  {
    $current_teacher = Auth::guard('teacher')->user();
    return view('teacher.data.confirm', ['current_teacher' => $current_teacher]);
  }

  public function confirm_password(Request $request)
  {
    $request->validate([
      'password' => 'required',
    ]);

    $current_teacher = Auth::guard('teacher')->user();

    if (Hash::check($request->password, $current_teacher->password)) {
      return redirect()->route('teacher.update', ['current_teacher' => $current_teacher]);
    }
    return redirect()->back()->withErrors(['password' => 'Invalid Password']);
  }

  public function showChangePasswordForm()
  {
    $current_teacher = Auth::guard('teacher')->user();
    return view('teacher.data.change_password', ['current_teacher' => $current_teacher]);
  }

  public function change_password(Request $request)
  {
    $request->validate([
      'old_password' => 'required',
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
    ]);

    $current_teacher = Auth::guard('teacher')->user();

    if (Hash::check($request->old_password, $current_teacher->password)) {
      $current_teacher->password = $request->password;
      $current_teacher->save();
      return redirect()->route('teacher.profile', ['current_teacher' => $current_teacher]);
    }
    return redirect()->back()->withErrors(['old_password' => 'Invalid Password']);
  }

  public function showUpdateForm()
  {
    $current_teacher = Auth::guard('teacher')->user();
    return view('teacher.data.update', compact('current_teacher'));
  }

  public function update(Request $request)
  {
    $current_teacher = Auth::guard('teacher')->user();
    $request->validate([
      'username' => ['required', 'string', 'max:255', new uniqueUsername($current_teacher->id)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail($current_teacher->id)],
    ]);


    $current_teacher->username = $request->username;
    $current_teacher->fname = $request->fname;
    $current_teacher->lname = $request->lname;
    $current_teacher->email = $request->email;
    $current_teacher->phone = $request->phone;
    $current_teacher->save();
    return redirect()->route('teacher.profile')->with('success', 'updated  successfully');
  }

  public function change_profile_photo(Teacher $teacher)
  {
    request()->validate([
      'image' => 'max:4096',
    ]);
    // Get the current image path
    $currentImage = $teacher->image;

    $file = null;
    $extension = null;
    $path = 'images/teacher/';
    $filename = null;
    $image = null;

    if (request()->has('image')) {
      $file = request()->file('image');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $image = $path . $filename;

      // Delete the current image if it exists
      if ($currentImage && file_exists($currentImage)) {
        unlink($currentImage);
      }
    }
    $teacher->update([
      'image' => $image,
    ]);
    return redirect()->route('teacher.profile', $teacher->id)->with('success', 'Photo is uploaded successfully');
  }

  public function logout()
  {
    Auth::guard('teacher')->logout();
    return  redirect()->route('login')->with('success', 'logout successfully');
  }


  public function uploadFiles(Request $request, $courseId)
  {
    $course = Course::findOrFail($courseId);

    $validator = Validator::make($request->all(), [
      'files.*' => 'required|file'
    ]);

    if ($validator->fails()) {
      return redirect()->back()->with(['error' => $validator->errors()->first()], 400);
    }

    foreach ($request->file('files') as $file) {
      $filePath = $file->store('courses/course_' . $course->title . '_files'); //  storage path

      $course->files()->create([
        'file_path' => $filePath,
        'file_type' => $file->getClientOriginalExtension(),
      ]);
    }

    return redirect()->back()->with(['success' => 'Files uploaded successfully']);
  }

  public function showPosts()
  {
    $posts = Post::all();
    return view('teacher.post.index', ['posts' => $posts]);
  }

  public function showPost($id)
    {
        $post = Post::with('comments.replies')->findOrFail($id);
        return view('teacher.post.show', compact('post'));
    }
}
