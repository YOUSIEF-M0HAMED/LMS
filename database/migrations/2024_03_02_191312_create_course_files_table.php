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
        Schema::create('course_files', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('course_id');
          $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
          $table->string('file_name');
          $table->string('file_path');
          $table->enum('file_type',['video','image','other']);
          $table->enum('section',['content','assignment']);
          $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_files');
    }
};