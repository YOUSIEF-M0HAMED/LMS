<?php

namespace App\Notifications;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuizAddedNotification extends Notification
{
    use Queueable;

    protected $quiz;

    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    public function via($notifiable)
    {
        return ['database'];
    }



    public function toArray($notifiable)
    {
        return [
            'quiz_id' => $this->quiz->id,
            'course_id' => $this->quiz->course->id,
            'course_name' => $this->quiz->course->name,
            'quiz_title' => $this->quiz->title,
        ];
    }

}