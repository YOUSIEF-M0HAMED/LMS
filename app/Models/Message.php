<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
      'sender_id',
      'sender_type',
      'course_id',
      'message',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);

    }

    public function sender()
    {
        return $this->morphTo();
    }


}