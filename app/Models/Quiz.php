<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'course_id',
    'from_time',
    'to_time',
    'duration',
  ];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function questions()
  {
    return $this->hasMany(Question::class);
  }

  public function studentQuizzes()
  {
    return $this->hasMany(StudentQuiz::class);
  }
}
