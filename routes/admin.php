<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAdministrationController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\StudentAdministrationController;
use App\Http\Controllers\Admin\TeacherAdministrationController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseStudentController;
use App\Models\Course;

// Admin Routes

Route::middleware(['admin','adminActivity'])->group(function () {

  Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('home', [AdminController::class, 'home'])->name('home');
    Route::prefix('data')->group(function () {
      Route::get('profile', [AdminController::class, 'showProfile'])->name('profile');
      Route::get('confirm_password', [AdminController::class, 'showConfirmPasswordForm'])->name('confirm_password');
      Route::post('confirm_password', [AdminController::class, 'confirm_password'])->name('confirm_password.submit');
      Route::get('update', [AdminController::class, 'showUpdateForm'])->name('update');
      Route::get('change_password', [AdminController::class, 'showChangePasswordForm'])->name('change_password');
      Route::post('change_password', [AdminController::class, 'change_password'])->name('change_password.submit');
      Route::get('update', [AdminController::class, 'showUpdateForm'])->name('update');
      Route::post('update', [AdminController::class, 'update'])->name('update.submit');
      Route::post('change_profile_photo/{admin}', [AdminController::class, 'change_profile_photo'])->name('change_profile_photo');
      Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    });
    Route::prefix('administration')->name('admins.')->group(function () {
      Route::get('admins', [AdminAdministrationController::class, 'index'])->name('index');
      Route::get('admins/create', [AdminAdministrationController::class, 'create'])->name('create');
      Route::post('admins', [AdminAdministrationController::class, 'store'])->name('store');
      Route::get('admins/{admin}', [AdminAdministrationController::class, 'show'])->name('show');
      Route::get('admins/{admin}/edit', [AdminAdministrationController::class, 'edit'])->name('edit');
      Route::put('admins/{admin}', [AdminAdministrationController::class, 'update'])->name('update');
      Route::post('change_profile_photo/{admin}', [AdminAdministrationController::class, 'change_profile_photo'])->name('change_profile_photo');
      Route::get('admins/{admin}/change_password', [AdminAdministrationController::class, 'showChangePasswordForm'])->name('change_password');
      Route::put('admins/{admin}/change_password', [AdminAdministrationController::class, 'changePassword'])->name('change_password');
      Route::delete('admins/{admin}', [AdminAdministrationController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('administration')->name('teachers.')->group(function () {
      Route::get('teachers', [TeacherAdministrationController::class, 'index'])->name('index');
      Route::get('teachers/deleted', [TeacherAdministrationController::class, 'deleted_teachers'])->name('deleted');
      Route::get('teachers/create', [TeacherAdministrationController::class, 'create'])->name('create');
      Route::post('teachers', [TeacherAdministrationController::class, 'store'])->name('store');
      Route::get('teachers/{teacher}', [TeacherAdministrationController::class, 'show'])->name('show');
      Route::get('teachers/{teacher}/edit', [TeacherAdministrationController::class, 'edit'])->name('edit');
      Route::put('teachers/{teacher}', [TeacherAdministrationController::class, 'update'])->name('update');
      Route::post('change_profile_photo/{teacher}', [TeacherAdministrationController::class, 'change_profile_photo'])->name('change_profile_photo');
      Route::get('teachers/{teacher}/change_password', [TeacherAdministrationController::class, 'showChangePasswordForm'])->name('change_password');
      Route::put('teachers/{teacher}/change_password', [TeacherAdministrationController::class, 'changePassword'])->name('change_password');
      Route::delete('teachers/{teacher}', [TeacherAdministrationController::class, 'destroy'])->name('destroy');
      Route::post('teachers/restore', [TeacherAdministrationController::class, 'restore_all'])->name('restore_all');
      Route::post('teachers/{teacher}/restore', [TeacherAdministrationController::class, 'restore_teacher'])->name('restore');
      Route::delete('teachers/{teacher}/force_delete', [TeacherAdministrationController::class, 'force_delete'])->name('force_delete');
      Route::delete('teachers/force_delete_all', [TeacherAdministrationController::class, 'force_delete_all'])->name('force_delete_all');
      Route::post('teachers-import', [TeacherAdministrationController::class, 'import'])->name('import');
      Route::get('teachers-export', [TeacherAdministrationController::class, 'export'])->name('export');
      Route::get('search_teachers', [TeacherAdministrationController::class, 'search'])->name('search_teachers');
    });
    Route::prefix('administration')->name('students.')->group(function () {
      Route::get('students', [StudentAdministrationController::class, 'index'])->name('index');
      Route::get('students/deleted', [StudentAdministrationController::class, 'deleted_students'])->name('deleted');
      Route::get('students/create', [StudentAdministrationController::class, 'create'])->name('create');
      Route::post('students', [StudentAdministrationController::class, 'store'])->name('store');

      Route::get('students/{student}', [StudentAdministrationController::class, 'show'])->name('show');
      Route::get('students/{student}/edit', [StudentAdministrationController::class, 'edit'])->name('edit');
      Route::put('students/{student}', [StudentAdministrationController::class, 'update'])->name('update');
      Route::post('change_profile_photo/{student}', [StudentAdministrationController::class, 'change_profile_photo'])->name('change_profile_photo');
      Route::get('students/{student}/change_password', [StudentAdministrationController::class, 'showChangePasswordForm'])->name('change_password');
      Route::put('students/{student}/change_password', [StudentAdministrationController::class, 'changePassword'])->name('change_password');
      Route::delete('students', [StudentAdministrationController::class, 'destroy_all'])->name('destroy_all');
      Route::delete('students/force_delete_all', [StudentAdministrationController::class, 'force_delete_all'])->name('force_delete_all');
      Route::delete('students/{student}', [StudentAdministrationController::class, 'destroy'])->name('destroy');
      Route::delete('students/{student}/force_delete', [StudentAdministrationController::class, 'force_delete'])->name('force_delete');

      Route::post('students/restore', [StudentAdministrationController::class, 'restore_all'])->name('restore_all');
      Route::post('students/{student}/restore', [StudentAdministrationController::class, 'restore_student'])->name('restore');

      Route::post('students-import', [StudentAdministrationController::class, 'import'])->name('import');
      Route::get('students-export', [StudentAdministrationController::class, 'export'])->name('export');
      Route::get('search', [StudentAdministrationController::class, 'search'])->name('search');

    });

    Route::prefix('post')->name('post.')->group(function () {
      Route::get('/', [PostController::class, 'index'])->name('index');
      Route::get('/create', [PostController::class, 'create'])->name('create');
      Route::post('/', [PostController::class, 'store'])->name('store');
      Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
      Route::put('/{post}', [PostController::class, 'update'])->name('update');
      Route::post('/{post}/change_image', [PostController::class, 'change_image'])->name('change_image');
      Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');

      //new
      Route::get('/{post}/show', [PostController::class, 'show'])->name('show');

    });

    //comments
    Route::prefix('comment')->name('comment.')->group(function () {
      Route::post('/store-comment', [CommentController::class, 'store'])->name('store');
      Route::post('/store-reply', [CommentController::class, 'storeReply'])->name('storeReply');
      Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
      Route::post('/{comment}', [CommentController::class, 'update'])->name('update');
      Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('administration')->name('course.')->group(function () {
      Route::get('/courses', [CourseController::class, 'index'])->name('index');
      Route::get('/courses/create', [CourseController::class, 'create'])->name('create');
      Route::post('/courses', [CourseController::class, 'store'])->name('store');
      Route::get('/courses/{course}', [CourseController::class, 'show'])->name('show');
      Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('edit');
      Route::put('/courses/{course}', [CourseController::class, 'update'])->name('update');
      Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('destroy');
      Route::post('courses-import', [CourseController::class, 'import'])->name('import');
      Route::get('courses-export', [CourseController::class, 'export'])->name('export');
    });

    Route::prefix('administration')->name('course_student.')->group(function () {
      Route::get('/courses_students', [CourseStudentController::class, 'index'])->name('index');
      Route::get('/courses_students/create', [CourseStudentController::class, 'create'])->name('create');
      Route::post('/courses_students', [CourseStudentController::class, 'store'])->name('store');
      Route::get('/courses_students/{course}', [CourseStudentController::class, 'show'])->name('show');
      Route::get('/courses_students/{student}/{course}/edit', [CourseStudentController::class, 'edit'])->name('edit');
      Route::put('/courses_students/{student}/{course}', [CourseStudentController::class, 'update'])->name('update');
      Route::delete('/courses_students/{student}/{course}', [CourseStudentController::class, 'destroy'])->name('destroy');
      Route::post('courses_students-import', [CourseStudentController::class, 'import'])->name('import');
      Route::get('courses_students-export', [CourseStudentController::class, 'export'])->name('export');
    });
  });
});