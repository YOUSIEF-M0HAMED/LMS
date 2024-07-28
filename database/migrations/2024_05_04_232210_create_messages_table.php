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
        Schema::create('messages', function (Blueprint $table) {
          $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->enum('sender_type',['teacher','student']); // Indicates whether the sender is a student or a teacher
            $table->unsignedBigInteger('course_id');
            $table->text('message');
            $table->enum('type',['text','voice']);
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};