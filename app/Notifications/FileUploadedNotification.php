<?php

namespace App\Notifications;

use App\Models\CourseFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FileUploadedNotification extends Notification
{
    use Queueable;
    protected $file;

    public function __construct(CourseFile $file)
    {
        $this->file = $file;
    }

    public function via($notifiable)
    {
        return ['database'];
    }



    public function toArray($notifiable)
    {
        return [
            'course_id' => $this->file->course->id,
            'course_name' => $this->file->course->name,
            'file_name' => $this->file->file_name,
        ];
    }
}