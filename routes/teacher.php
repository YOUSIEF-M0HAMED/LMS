<?php

use App\Http\Controllers\Teacher\ChatController;
use App\Http\Controllers\Teacher\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\CourseFileController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Teacher\QuizController;

// Teacher Routes

Route::middleware(['teacher', 'teacherActivity'])->group(function () {
  Route::namespace('Teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('home', [TeacherController::class, 'home'])->name('home');
    Route::prefix('data')->group(function () {
      Route::get('profile', [TeacherController::class, 'showProfile'])->name('profile');
      Route::get('confirm_password', [TeacherController::class, 'showConfirmPasswordForm'])->name('confirm_password');
      Route::post('confirm_password', [TeacherController::class, 'confirm_password'])->name('confirm_password.submit');
      Route::get('update', [TeacherController::class, 'showUpdateForm'])->name('update');
      Route::get('change_password', [TeacherController::class, 'showChangePasswordForm'])->name('change_password');
      Route::post('change_password', [TeacherController::class, 'change_password'])->name('change_password.submit');
      Route::get('update', [TeacherController::class, 'showUpdateForm'])->name('update');
      Route::post('update', [TeacherController::class, 'update'])->name('update.submit');
      Route::post('change_profile_photo/{teacher}', [TeacherController::class, 'change_profile_photo'])->name('change_profile_photo');
      Route::get('logout', [TeacherController::class, 'logout'])->name('logout');



      Route::prefix('courses')->name('courses.')->group(function () {

        Route::get('/index', [CourseController::class, 'index'])->name('index');
        Route::get('/show/{course}', [CourseController::class, 'show'])->name('show');

        Route::prefix('courseFiles')->name('courseFiles.')->group(function () {
          Route::get('/course_file/create/{course}', [CourseFileController::class, 'create'])->name('create');
          Route::post('/course_file/store/{course}', [CourseFileController::class, 'store'])->name('store');
          Route::delete('/course_file/DeleteOne/{courseFile}', [CourseFileController::class, 'destroy'])->name('destroy');
          Route::delete('/course_file/DeleteAllContent/{course}', [CourseFileController::class, 'destroyAllCourseContent'])->name('destroyAllCourseContent');
          Route::delete('/course_file/DeleteAllAssignments/{course}', [CourseFileController::class, 'destroyAllCourseAssignments'])->name('destroyAllCourseAssignments');
        });

        //Chat

        Route::get('/course/{courseId}/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
        Route::get('/chat/latest-messages/{courseId}', [ChatController::class, 'getLatestMessages'])->name('chat.latestMessages');

        Route::get('/course/{courseId}/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
        Route::get('/chat/latest-messages/{courseId}', [ChatController::class, 'getLatestMessages'])->name('chat.latestMessages');
        Route::post('/upload-voice', [ChatController::class, 'uploadVoice'])->name('chat.uploadVoice');
      });
    });

    Route::prefix('quiz')->name('quiz.')->group(function () {
      Route::get('/', [QuizController::class, 'index'])->name('index');
      Route::get('/create', [QuizController::class, 'create'])->name('create');
      Route::post('/', [QuizController::class, 'store'])->name('store');
      Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');
      Route::get('/{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
      Route::put('/{quiz}', [QuizController::class, 'update'])->name('update');
      Route::delete('/{quiz}', [QuizController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('question')->name('question.')->group(function () {
      Route::get('/{quiz_id}', [QuestionController::class, 'index'])->name('index');
      Route::get('/create/{quiz_id}', [QuestionController::class, 'create'])->name('create');
      Route::post('/', [QuestionController::class, 'store'])->name('store');
      Route::get('/{question}', [QuestionController::class, 'show'])->name('show');
      Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
      Route::put('/{question}', [QuestionController::class, 'update'])->name('update');
      Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('grade')->name('grade.')->group(function () {
      Route::get('/students/{quiz_id}', [GradeController::class, 'show'])->name('show');
      Route::get('/students/{quizId}/students/export', [GradeController::class, 'export'])->name('export');
    });

    Route::prefix('post')->name('post.')->group(function () {
      Route::get('/', [TeacherController::class, 'showPosts'])->name('index');
      Route::get('/{post}/show', [TeacherController::class, 'showPost'])->name('show');

    });


    //comments
    Route::prefix('comment')->name('comment.')->group(function () {
      Route::post('/store-comment', [CommentController::class, 'store'])->name('store');
      Route::post('/store-reply', [CommentController::class, 'storeReply'])->name('storeReply');
      Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
      Route::post('/{comment}', [CommentController::class, 'update'])->name('update');
      Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');

    });
  });
});