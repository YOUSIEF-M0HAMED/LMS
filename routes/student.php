<?php

use App\Http\Controllers\Student\ChatController;
use App\Http\Controllers\Student\CommentController;
use App\Http\Controllers\Student\QuizGradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\NotificationController;
use App\Http\Controllers\Student\TestController;

// Student Routes
Route::middleware(['student', 'studentActivity'])->group(function () {
  Route::namespace('Student')->prefix('student')->name('student.')->group(function () {
    Route::get('home', [StudentController::class, 'home'])->name('home');
    Route::prefix('data')->group(function () {
      Route::get('profile', [StudentController::class, 'showProfile'])->name('profile');
      Route::get('confirm_password', [StudentController::class, 'showConfirmPasswordForm'])->name('confirm_password');
      Route::post('confirm_password', [StudentController::class, 'confirm_password'])->name('confirm_password.submit');
      Route::get('update', [StudentController::class, 'showUpdateForm'])->name('update');
      Route::get('change_password', [StudentController::class, 'showChangePasswordForm'])->name('change_password');
      Route::post('change_password', [StudentController::class, 'change_password'])->name('change_password.submit');
      Route::get('update', [StudentController::class, 'showUpdateForm'])->name('update');
      Route::post('update', [StudentController::class, 'update'])->name('update.submit');
      Route::post('change_profile_photo/{student}', [StudentController::class, 'change_profile_photo'])->name('change_profile_photo');
      Route::get('logout', [StudentController::class, 'logout'])->name('logout');

      Route::get('/show/{course}', [StudentController::class, 'showCourse'])->name('courses.showCourse');

      //Chat
      Route::get('/course/{courseId}/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
      Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
      Route::get('/chat/latest-messages/{courseId}', [ChatController::class, 'getLatestMessages'])->name('chat.latestMessages');

      Route::post('/upload-voice', [ChatController::class, 'uploadVoice'])->name('chat.uploadVoice');

      //Notifications
      Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
      Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    });

    // QuizGrade
    Route::prefix('quiz')->name('quizGrade.')->group(function () {
      Route::get('quizGrade/', [QuizGradeController::class, 'showQuizzes'])->name('showQuizzes');
      Route::get('quizGrade/grades', [QuizGradeController::class, 'showGrades'])->name('showGrades');
    });
    // Quiz
    Route::prefix('test')->name('test.')->group(function () {
      Route::get('quiz/grade/{quiz_id}', [TestController::class, 'grade'])->name('grade');
      Route::get('quiz/{quiz_id}', [TestController::class, 'showQuiz'])
        ->middleware('quiz.eligible')->name('show');
      Route::post('quiz/store/{quiz_id}', [TestController::class, 'store'])->name('store');
    });

    Route::prefix('post')->name('post.')->group(function () {
      Route::get('/show-posts', [StudentController::class, 'showPosts'])->name('index');
      Route::get('/{post}/show', [StudentController::class, 'showPost'])->name('show');

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