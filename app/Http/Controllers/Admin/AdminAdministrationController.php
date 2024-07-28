<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Rules\uniqueEmail;
use App\Rules\uniqueUserId;
use Illuminate\Http\Request;
use App\Rules\uniqueUsername;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAdministrationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $allAdmins = Admin::skip(1)->take(PHP_INT_MAX)->get();
    return view('admin.administration.admins.index', ['allAdmins' => $allAdmins]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.administration.admins.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'admin_id' => ['required', 'string', 'max:255', new uniqueUserId(null)],
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
    $path = 'images/admin/';
    $filename = null;
    $image = null;
    if ($request->has('image')) {
      $file = $request->file('image');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $image = $path . $filename;
    }
    Admin::create([
      'admin_id' => $request->admin_id,
      'username' => $request->username,
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'image' => $image,
    ]);

    return redirect()->route('admin.admins.index')->with('success', 'Admin registered successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Admin $admin)
  {
    return view('admin.administration.admins.show', ['admin' => $admin]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Admin $admin)
  {
    return view('admin.administration.admins.edit', ['admin' => $admin]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Admin $admin)
  {
    request()->validate([
      'admin_id' => ['required', 'string', 'max:255', new uniqueUserId(request()->id)],
      'username' => ['required', 'string', 'max:255', new uniqueUsername(request()->id)],
      'fname' => 'required|string|max:255',
      'lname' => 'required|string|max:255',
      'email' => ['required', 'email', 'max:255', new uniqueEmail(request()->id)],

    ]);

    $admin->update([
      'admin_id' => request()->admin_id,
      'username' => request()->username,
      'fname' => request()->fname,
      'lname' => request()->lname,
      'email' => request()->email,
      'phone' => request()->phone,
    ]);

    return redirect()->route('admin.admins.show', $admin->id)->with('success', 'Admin updated successfully!');
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
    return redirect()->route('admin.admins.show', $admin->id)->with('success', 'Photo is uploaded successfully');
  }

  public function showChangePasswordForm($id)
  {
    return view('admin.administration.admins.change_password', ['id' => $id]);
  }

  public function changePassword(Admin $admin)
  {
    request()->validate([
      'password' => 'required|string|min:8',
      'password_confirmation' => 'required|same:password',
    ]);

    $admin->update([
      'password' => Hash::make(request()->password),
    ]);
    return redirect()->route('admin.admins.edit', $admin->id)->with('success', 'Password updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Admin $admin)
  {
    $admin->delete();
    return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully!');
  }
}
