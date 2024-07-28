<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Models\Student;
use App\Rules\uniqueEmail;
use App\Rules\uniqueUserId;
use Illuminate\Http\Request;
use App\Rules\uniqueUsername;
use App\Imports\StudentsImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentAdministrationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $allStudents = Student::all();
    return view('admin.administration.students.index', ['allStudents' => $allStudents]);
  }

  public function deleted_students()
  {
    $deletedStudents = Student::onlyTrashed()->get();
    return view('admin.administration.students.deleted_students', ['deletedStudents' => $deletedStudents]);
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.administration.students.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'student_id' => ['required', 'string', 'max:255', new uniqueUserId(null)],
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
    $path = 'images/student/';
    $filename = null;
    $image = null;
    if ($request->has('image')) {
      $file = $request->file('image');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $image = $path . $filename;
    }
    Student::create([
      'student_id' => $request->student_id,
      'username' => $request->username,
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'image' => $image,
    ]);

    return redirect()->route('admin.students.index')->with('success', 'Student registered successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Student $student)
  {
    return view('admin.administration.students.show', ['student' => $student]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Student $student)
  {
    return view('admin.administration.students.edit', ['student' => $student]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Student $student)
  {
    request()->validate([
      'student_id' => ['required', 'string', 'max:255', new uniqueUserId(request()->id)],
      'username' => ['required', 'string', 'max:255', new uniqueUsername(request()->id)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail(request()->id)],

    ]);

    $student->update([
      'student_id' => request()->student_id,
      'username' => request()->username,
      'fname' => request()->fname,
      'lname' => request()->lname,
      'email' => request()->email,
      'phone' => request()->phone,
    ]);

    return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
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
    return redirect()->route('admin.students.show', $student->id)->with('success', 'Photo is uploaded successfully');
  }



  public function showChangePasswordForm($id)
  {
    return view('admin.administration.students.change_password', ['id' => $id]);
  }

  public function changePassword(Student $student)
  {
    request()->validate([
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
    ]);

    $student->update([
      'password' => Hash::make(request()->password),
    ]);
    return redirect()->route('admin.students.edit', $student->id)->with('success', 'Password updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Student $student)
  {
    $student->delete();
    return redirect()->route('admin.students.index')->with('success', 'Student is deleted successfully!');
  }

  public function destroy_all()
  {
    Student::withTrashed()->delete();
    return redirect()->route('admin.students.index')->with('success', 'All students are deleted successfully!');
  }

  public function force_delete_all()
  {
    Student::onlyTrashed()->forceDelete();
    return redirect()->back()->with('success', 'All students are deleted permanently successfully!');
  }

  public function force_delete($id)
  {
    $deletedStudent = Student::onlyTrashed()->find($id);
    $deletedStudent->forceDelete();
    return redirect()->back()->with('success', 'Student is deleted permanently successfully!');
  }

  public function restore_all()
  {
    Student::onlyTrashed()->restore();
    return redirect()->back()->with('success', 'All students are restored successfully');
  }

  public function restore_student($id)
  {
    $deletedStudent = Student::onlyTrashed()->find($id);
    $deletedStudent->restore();
    return redirect()->back()->with('success', 'Student is restored successfully');
  }

  public function import()
  {
    request()->validate([
      'file' => 'required',
    ]);
    Excel::import(new StudentsImport, request()->file('file'));
    return redirect()->back()->with('success', 'Students imported successfully');
  }

  public function export()
  {
    return Excel::download(new StudentsExport, 'students.xlsx');
  }

  public function search(Request $request)
  {
      $search = $request->input('search');
     
    // Search by username or id
    $student  = Student::where('student_id', $search)->orWhere('username', $search)->get();
   
      return view('admin.administration.students.index', ['student1' => $student]);  }
}

