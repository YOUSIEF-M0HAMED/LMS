<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewMessageNotification;


class NotifyStudentsOfNewMessage
{

    public function handle(MessageSent $event)
    {
        $course = $event->message->course;
        $students = $course->students;

        foreach ($students as $student) {
            $student->notify(new NewMessageNotification($event->message));
        }
    }
}