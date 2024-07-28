<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;


class NewMessageNotification extends Notification
{
  use Queueable;

  protected $message;

  public function __construct(Message $message)
  {
      $this->message = $message;
  }

  public function via($notifiable)
  {
      return ['database'];
  }


  public function toArray($notifiable)
  {
      return [
          'course_id' => $this->message->course->id,
          'course_name' => $this->message->course->name,
          'message' => $this->message->message,
      ];
  }
}