<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// local setting
Route::get('lang/{locale}', function ($locale) {
  if (in_array($locale, ['en', 'ar'])) {
    session(['locale' => $locale]);
  }
  return redirect()->back();
})->name('switch.language');


// Login Page
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.submit');

// Forget Password
Route::get('forget-password', [LoginController::class, 'forgetPassword'])->name('password.request');
Route::post('password-email', [LoginController::class, 'passwordEmail'])->name('password.email');

Route::get('password/reset/{token}/{email}', [LoginController::class, 'resetPassword'])->name('password.reset');
Route::post('password-update', [LoginController::class, 'updatePassword'])->name('password.update');
