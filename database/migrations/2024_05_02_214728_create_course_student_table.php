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
        Schema::create('course_student', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('course_id');
          $table->unsignedBigInteger('student_id');
          $table->timestamps();

          // Define foreign key constraints
          $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
          $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');

          // Optionally, you can add unique constraints if you don't want duplicate relationships
          $table->unique(['course_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_student');
    }
};