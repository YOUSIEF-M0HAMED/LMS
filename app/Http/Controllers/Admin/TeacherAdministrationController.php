<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use App\Rules\uniqueEmail;
use App\Rules\uniqueUserId;
use Illuminate\Http\Request;
use App\Rules\uniqueUsername;
use App\Exports\TeachersExport;
use App\Imports\TeachersImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class TeacherAdministrationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $allTeachers = Teacher::all();
    return view('admin.administration.teachers.index', ['allTeachers' => $allTeachers]);
  }

  public function deleted_teachers()
  {
    $deletedTeachers = Teacher::onlyTrashed()->get();
    return view('admin.administration.teachers.deleted_teachers', ['deletedTeachers' => $deletedTeachers]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.administration.teachers.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'teacher_id' => ['required', 'string', 'max:255', new uniqueUserId(null)],
      'username' => ['required', 'string', 'max:255', new uniqueUsername(null)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail(null)],
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
      'image' => 'max:4096',
    ]);
    $file = null;
    $extension = null;
    $path = 'images/teacher/';
    $filename = null;
    $image = null;
    if ($request->has('image')) {
      $file = $request->file('image');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $image = $path . $filename;
    }
    Teacher::create([
      'teacher_id' => $request->teacher_id,
      'username' => $request->username,
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'image' => $image,
    ]);

    return redirect()->route('admin.teachers.index')->with('success', 'Teacher registered successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Teacher $teacher)
  {
    return view('admin.administration.teachers.show', ['teacher' => $teacher]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Teacher $teacher)
  {
    return view('admin.administration.teachers.edit', ['teacher' => $teacher]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Teacher $teacher)
  {
    request()->validate([
      'teacher_id' => ['required', 'string', 'max:255', new uniqueUserId(request()->id)],
      'username' => ['required', 'string', 'max:255', new uniqueUsername(request()->id)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail(request()->id)],

    ]);

    $teacher->update([
      'teacher_id' => request()->teacher_id,
      'username' => request()->username,
      'fname' => request()->fname,
      'lname' => request()->lname,
      'email' => request()->email,
      'phone' => request()->phone,
    ]);

    return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully!');
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
    return redirect()->route('admin.teachers.show', $teacher->id)->with('success', 'Photo is uploaded successfully');
  }

  public function showChangePasswordForm($id)
  {
    return view('admin.administration.teachers.change_password', ['id' => $id]);
  }

  public function changePassword(Teacher $teacher)
  {
    request()->validate([
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
    ]);

    $teacher->update([
      'password' => Hash::make(request()->password),
    ]);
    return redirect()->route('admin.teachers.edit', $teacher->id)->with('success', 'Password updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Teacher $teacher)
  {
    $teacher->delete();
    return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully!');
  }


  public function force_delete_all()
  {
    Teacher::onlyTrashed()->forceDelete();
    return redirect()->back()->with('success', 'All teachers are deleted permanently successfully!');
  }

  public function force_delete($id)
  {
    $deletedTeacher = Teacher::onlyTrashed()->find($id);
    $deletedTeacher->forceDelete();
    return redirect()->back()->with('success', 'teacher is deleted permanently successfully!');
  }

  public function restore_all()
  {
    Teacher::onlyTrashed()->restore();
    return redirect()->back()->with('success', 'All teachers are restored successfully');
  }

  public function restore_teacher($id)
  {
    $deletedTeacher = Teacher::onlyTrashed()->find($id);
    $deletedTeacher->restore();
    return redirect()->back()->with('success', 'Student is restored successfully');
  }


  public function import()
  {
    request()->validate([
      'file' => 'required',
    ]);
    Excel::import(new TeachersImport, request()->file('file'));
    return redirect()->back()->with('success', 'Teachers imported successfully');
  }


  public function export()
  {
    return Excel::download(new TeachersExport, 'teachers.xlsx');
  }
  public function search(Request $request)
  {
      $search = $request->input('search');
     
    // Search by username or id
    $teacher = Teacher::where('teacher_id', $search)->orWhere('username', $search)->get();
   
      return view('admin.administration.teachers.index', ['teacher1' => $teacher]);  }
}