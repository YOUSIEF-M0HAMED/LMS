<?php

namespace App\Listeners;

use App\Events\QuizAdded;
use App\Notifications\QuizAddedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyStudentsOfQuizAdded
{
  public function handle(QuizAdded $event)
  {
      $course = $event->quiz->course;
      $students = $course->students;

      foreach ($students as $student) {
          $student->notify(new QuizAddedNotification($event->quiz));
      }
  }
}