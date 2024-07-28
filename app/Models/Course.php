<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'teacher_id',
    'course_code',
    'name',
    'specification',
    'logo',
  ];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function courseFiles()
  {
    return $this->hasMany(CourseFile::class);
  }

  public function quizzes(): HasMany
  {
    return $this->hasMany(Quiz::class);
  }

  public function answers()
  {
    return $this->hasMany(StudentAnswer::class);
  }

  public function students(): BelongsToMany
  {
    return $this->belongsToMany(Student::class, 'course_student');
  }

  public function messages()
  {
    return $this->hasMany(Message::class);
  }
}
