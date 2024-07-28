<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
  public function showLoginForm()
  {
    if (Auth::guard('admin')->check()) {
      return view('admin.home');
    } elseif (Auth::guard('teacher')->check()) {
      return view('teacher.home');
    } elseif (Auth::guard('student')->check()) {
      return view('student.home');
    } else {
      return view('auth.login');
    }
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $admin = Admin::where('email', $request->email)->first();
    $teacher = Teacher::where('email', $request->email)->first();
    $student = Student::where('email', $request->email)->first();
    $credentials = $request->only('email', 'password');

    if ($admin && Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
      return redirect()->route('admin.home')->with('success', 'Login Successfully');
    } elseif ($teacher && Auth::guard('teacher')->attempt($credentials, $request->has('remember'))) {
      return redirect()->route('teacher.home')->with('success', 'Login Successfully');
    } elseif ($student && Auth::guard('student')->attempt($credentials, $request->has('remember'))) {
      return redirect()->route('student.home')->with('success', 'Login Successfully');
    }

    return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
  }

  public function forgetPassword()
  {
    return view('auth.passwords.email');
  }
  protected $user;
  protected $user_data;

  public function passwordEmail(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
    ]);
    $admin = Admin::where('email', $request->email)->exists();
    $teacher = Teacher::where('email', $request->email)->exists();
    $student = Student::where('email', $request->email)->exists();
    if ($admin) {
      $user = Admin::where('email', $request->email)->first();
    } else if ($teacher) {
      $user = Teacher::where('email', $request->email)->first();
    } else if ($student) {
      $user = Student::where('email', $request->email)->first();
    } else {
      return redirect()->back()->with('error', 'Email is not found');
    }
    $token = hash('sha256', time());
    $user->token = $token;
    $user->update();
    $reset_link = url('password/reset/' . $token . '/' . $request->email);
    $subject = 'Reset Password Notification';
    $message = "
      <div class='message text-secondary'>
                  <h4 class='title text-dark'>Hello!</h4>
                  <div class='body'>
                      <p>You are receiving this email because we received a password reset request for your account.
                      </p>

                      <p class='text-center my-5'><a class='btn btn-dark'href='" . $reset_link . "'>Reset Password</a>
                      </p>

                      <p>This password reset link will expire in 60 minutes.</p>

                      <p>If you did not request a password reset, no further action is required.</p>

                      <p>Edumate</p>
                  </div>
              </div>";
    Mail::to($request->email)->send(new Websitemail($subject, $message));
    return redirect()->route('password.request')->with('status', 'We have emailed your password reset link.');
  }

  public function resetPassword($token, $email)
  {
    $admin = Admin::where('email', $email)->where('token', $token)->first();
    $teacher = Teacher::where('email', $email)->where('token', $token)->first();
    $student = Student::where('email', $email)->where('token', $token)->first();
    if (!$admin && !$teacher && !$student) {
      return redirect()->route('login')->with('error', 'Invalid token or password');
    }

    return view('auth.passwords.reset', compact('token', 'email'));
  }

  public function updatePassword(Request $request)
  {
    $request->validate([
      'password' => 'required|min:8',
      'password_confirmation' => 'required|same:password',
    ]);
    $admin = Admin::where('email', $request->email)->where('token', $request->token)->first();
    $teacher = Teacher::where('email', $request->email)->where('token', $request->token)->first();
    $student = Student::where('email', $request->email)->where('token', $request->token)->first();
    if ($admin) {
      $user_data = Admin::where('email', $request->email)->where('token', $request->token)->first();
    } else if ($teacher) {
      $user_data = Teacher::where('email', $request->email)->where('token', $request->token)->first();
    } else if ($student) {
      $user_data = Student::where('email', $request->email)->where('token', $request->token)->first();
    } else {
      return redirect()->route('login')->with('error', 'Invalid token or password');
    }

    $user_data->password = Hash::make($request->password);
    $user_data->token = "";
    $user_data->update();

    return redirect()->route('login')->with('success', 'Password reset successfully');
  }
}
