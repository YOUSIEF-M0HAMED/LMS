<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
  use HasFactory;

  protected $fillable = [
    'question_id',
    'student_id',
    'selected_option',
  ];

  public function question()
  {
    return $this->belongsTo(Question::class);
  }

  public function student()
  {
    return $this->belongsTo(Student::class);
  }
}
