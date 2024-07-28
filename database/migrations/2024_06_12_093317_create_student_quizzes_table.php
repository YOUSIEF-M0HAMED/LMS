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
    Schema::create('student_quizzes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('student_id');
      $table->unsignedBigInteger('quiz_id');
      $table->integer('score');
      $table->timestamp('taken_at');
      $table->timestamps();

      $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
      $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_quizzes');
  }
};
