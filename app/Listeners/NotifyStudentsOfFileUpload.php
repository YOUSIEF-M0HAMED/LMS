<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\FileUploadedNotification;


class NotifyStudentsOfFileUpload
{
  public function handle(FileUploaded $event)
  {
      $course = $event->file->course;
      $students = $course->students;

      foreach ($students as $student) {
          $student->notify(new FileUploadedNotification($event->file));
      }
  }
}