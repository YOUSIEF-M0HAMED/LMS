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
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id')->nullable();
      $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('CASCADE')->onUpdate('CASCADE');
      $table->string('course_code')->unique();
      $table->string('name');
      $table->text('specification')->nullable();
      $table->text('logo')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('courses');
  }
};
