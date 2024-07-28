<?php

namespace App\Http\Controllers\Student;

use App\Rules\uniqueEmail;
use App\Rules\uniqueUserId;
use Illuminate\Http\Request;
use App\Rules\uniqueUsername;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentQuiz ;


class StudentController extends Controller
{

  public function home()
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    $student = Auth::guard('student')->user();
    $courses = $student->courses;
    $notifications = $student->unreadNotifications;

    $completedQuizzes = StudentQuiz::from('quizzes')
      ->join('student_quizzes', 'student_quizzes.quiz_id', '=', 'quizzes.id')
      ->where('student_quizzes.student_id', $student->id)
      ->where('to_time', '<', now())
      ->count();

    $upcomingQuizzes = StudentQuiz::from('quizzes')
      ->join('student_quizzes', 'student_quizzes.quiz_id', '=', 'quizzes.id')
      ->where('student_quizzes.student_id', $student->id)
      ->where('from_time', '>', now())
      ->count();

    $activeQuizzes = StudentQuiz::from('quizzes')
      ->join('student_quizzes', 'student_quizzes.quiz_id', '=', 'quizzes.id')
      ->where('student_quizzes.student_id', $student->id)
      ->where('from_time', '<=', now())
      ->where('to_time', '>=', now())
      ->count();

    $totalQuizzes = $completedQuizzes + $activeQuizzes + $upcomingQuizzes;

    return view('student.home', compact(
      'student',
      'courses',
      'totalQuizzes',
      'notifications',
      'activeQuizzes',
      'upcomingQuizzes',
      'completedQuizzes',
    ));
  }


  public function showProfile()
  {
    $current_student = Auth::guard('student')->user();
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    return view('student.data.profile', [
      'current_student' => $current_student,
      'notifications' => $notifications,

    ]);
  }

  public function showConfirmPasswordForm()
  {
    $current_student = Auth::guard('student')->user();
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    return view('student.data.confirm', [
      'current_student' => $current_student,
      'notifications' => $notifications,
    ]);
  }

  public function confirm_password(Request $request)
  {
    $request->validate([
      'password' => 'required',
    ]);

    $current_student = Auth::guard('student')->user();
    $notifications = auth()->guard('student')->user()->unreadNotifications;


    if (Hash::check($request->password, $current_student->password)) {
      return redirect()->route('student.update', [
        'current_student' => $current_student,
        'notifications' => $notifications,
      ]);
    }
    return redirect()->back()->withErrors([
      'password' => 'Invalid Password',
      'notifications' => $notifications,
    ]);
  }

  public function showChangePasswordForm()
  {
    $current_student = Auth::guard('student')->user();
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    return view('student.data.change_password', [
      'current_student' => $current_student,
      'notifications' => $notifications,
    ]);
  }

  public function change_password(Request $request)
  {
    $request->validate([
      'old_password' => 'required',
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
    ]);
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    $current_student = Auth::guard('student')->user();

    if (Hash::check($request->old_password, $current_student->password)) {
      $current_student->password = $request->password;
      $current_student->save();
      return redirect()->route('student.profile', [
        'current_student' => $current_student,
        'notifications' => $notifications,
      ]);
    }
    return redirect()->back()->withErrors(['old_password' => 'Invalid Password']);
  }

  public function showUpdateForm()
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    $current_student = Auth::guard('student')->user();
    return view('student.data.update', compact('current_student', 'notifications'));
  }

  public function update(Request $request)
  {
    $current_student = Auth::guard('student')->user();
    $request->validate([
      'username' => ['required', 'string', 'max:255', new uniqueUsername($current_student->id)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail($current_student->id)],
    ]);


    $current_student->username = $request->username;
    $current_student->fname = $request->fname;
    $current_student->lname = $request->lname;
    $current_student->email = $request->email;
    $current_student->phone = $request->phone;
    $current_student->save();
    return redirect()->route('student.profile')->with('success', 'updated  successfully');
  }

  public function change_profile_photo(Student $student)
  {
    request()->validate([
      'image' => 'max:4096',
    ]);
    // Get the current image path
    $currentImage = $student->image;

    $file = null;
    $extension = null;
    $path = 'images/student/';
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
    $student->update([
      'image' => $image,
    ]);
    return redirect()->route('student.profile', $student->id)->with('success', 'Photo is uploaded successfully');
  }

  public function logout()
  {
    Auth::guard('student')->logout();
    return  redirect()->route('login')->with('success', 'logout successfully');
  }


  public function showPosts()
  {
    $posts = Post::all();
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    return view('student.post.index', compact('posts', 'notifications'));
  }

  public function showPost($id)
    {
        $notifications = auth()->guard('student')->user()->unreadNotifications;
        $post = Post::with('comments.replies')->findOrFail($id);
        return view('student.post.show', compact('post', 'notifications'));
    }

  public function showCourse(Course $course)
  {
    $notifications = auth()->guard('student')->user()->unreadNotifications;
    $courseContentFiles = $course->courseFiles->where('section', 'content')->all();
    $courseAssignmentFiles = $course->courseFiles->where('section', 'assignment')->all();
    $courseQuizzes = $course->quizzes;
    return view(
      'student.courses.show',
      compact(
        'course',
        'courseContentFiles',
        'courseAssignmentFiles',
        'courseQuizzes',
        'notifications'
      )
    );
  }
}