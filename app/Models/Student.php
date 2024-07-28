<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Student extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $guard = 'student';
  
  
  protected $fillable = [
    'student_id',
    'username',
    'fname',
    'lname',
    'email',
    'password',
    'phone',
    'image',
    'token',
    'last_seen',
  ];


  
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];


  public function courses(): BelongsToMany
  {
    return $this->belongsToMany(Course::class, 'course_student');
  }

  public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

  public function studentQuizzes()
  {
    return $this->hasMany(StudentQuiz::class);
  }
  public function teachers()
  {
      return $this->courses()->with('teacher')->get()->pluck('teacher')->unique();
  } 
}