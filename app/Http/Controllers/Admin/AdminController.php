<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\Teacher;
use App\Rules\uniqueEmail;
use App\Rules\uniqueUserId;
use Illuminate\Http\Request;
use App\Rules\uniqueUsername;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

  public function home()
  {
    
    $coursesNumbers = Course::count();
    $teacherCount = Teacher::count();
    $studentCount = Student::count();
    $onlineStudentCount = Student::where('last_seen', '>=', now()->subMinutes(2))->count();
    $onlineTeacherCount = Teacher::where('last_seen', '>=', now()->subMinutes(2))->count();
    $onlineStudentPercentage = $studentCount > 0 ? ($onlineStudentCount / $studentCount) * 100 : 0;
    $onlineTeacherPercentage = $studentCount > 0 ? ($onlineTeacherCount / $teacherCount) * 100 : 0;

    $totalQuizzes = Quiz::count();
    $completedQuizzes = Quiz::where('to_time', '<', now())->count();
    $upcomingQuizzes = Quiz::where('from_time', '>', now())->count();
    $activeQuizzes = Quiz::where('from_time', '<=', now())->where('to_time', '>=', now())->count();

    // Calculate percentages
    $completedPercentage = $totalQuizzes > 0 ? ($completedQuizzes / $totalQuizzes) * 100 : 0;
    $upcomingPercentage = $totalQuizzes > 0 ? ($upcomingQuizzes / $totalQuizzes) * 100 : 0;
    $activePercentage = $totalQuizzes > 0 ? ($activeQuizzes / $totalQuizzes) * 100 : 0;

    return view('admin.home', compact(
      'coursesNumbers',
      'studentCount',
      'teacherCount',
      'totalQuizzes',
      'activeQuizzes',
      'upcomingQuizzes',
      'completedQuizzes',
      'activePercentage',
      'onlineStudentCount',
      'onlineTeacherCount',
      'upcomingPercentage',
      'completedPercentage',
      'onlineStudentPercentage',
      'onlineTeacherPercentage',
      
    ));
  }


  public function showProfile()
  {
    return view('admin.data.profile');
  }

  public function showConfirmPasswordForm()
  {
    return view('admin.data.confirm');
  }

  public function confirm_password(Request $request)
  {
    $request->validate([
      'password' => 'required',
    ]);

    $current_admin = Auth::guard('admin')->user();

    if (Hash::check($request->password, $current_admin->password)) {
      return redirect()->route('admin.update', ['current_admin' => $current_admin]);
    }
    return redirect()->back()->withErrors(['password' => 'Invalid Password']);
  }

  public function showChangePasswordForm()
  {
    return view('admin.data.change_password');
  }

  public function change_password(Request $request)
  {
    $request->validate([
      'old_password' => 'required',
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
    ]);

    $current_admin = Auth::guard('admin')->user();

    if (Hash::check($request->old_password, $current_admin->password)) {
      $current_admin->password = $request->password;
      $current_admin->save();
      return redirect()->route('admin.profile', ['current_admin' => $current_admin]);
    }
    return redirect()->back()->withErrors(['old_password' => 'Invalid Password']);
  }

  public function showUpdateForm()
  {
    return view('admin.data.update');
  }

  public function update(Request $request)
  {
    $current_admin = Auth::guard('admin')->user();
    $request->validate([
      'admin_id' => ['required', 'string', 'max:255', new uniqueUserId($current_admin->id)],
      'username' => ['required', 'string', 'max:255', new uniqueUsername($current_admin->id)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail($current_admin->id)],
    ]);


    $current_admin->admin_id = $request->admin_id;
    $current_admin->username = $request->username;
    $current_admin->fname = $request->fname;
    $current_admin->lname = $request->lname;
    $current_admin->email = $request->email;
    $current_admin->phone = $request->phone;
    $current_admin->save();
    return redirect()->route('admin.profile')->with('success', 'updated  successfully');
  }

  public function change_profile_photo(Admin $admin)
  {
    request()->validate([
      'image' => 'max:4096',
    ]);
    // Get the current image path
    $currentImage = $admin->image;

    $file = null;
    $extension = null;
    $path = 'images/admin/';
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
    $admin->update([
      'image' => $image,
    ]);
    return redirect()->route('admin.profile', $admin->id)->with('success', 'Photo is uploaded successfully');
  }

  public function logout()
  {
    Auth::guard('admin')->logout();
    return  redirect()->route('login')->with('success', 'logout successfully');
  }
}
