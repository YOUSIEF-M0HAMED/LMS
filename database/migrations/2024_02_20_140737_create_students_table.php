<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('students', function (Blueprint $table) {
      $table->id();
      $table->string('student_id')->unique();
      $table->string('username')->unique();
      $table->string('fname');
      $table->string('lname');
      $table->string('email')->unique();
      $table->string('password');
      $table->string('phone')->nullable();
      $table->text('image')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('token')->nullable();
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('students');
  }
};