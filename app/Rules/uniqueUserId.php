<?php

namespace App\Rules;

use Closure;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Contracts\Validation\ValidationRule;

class uniqueUserId implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */

  protected $exceptId;

  public function __construct($exceptId)
  {
    $this->exceptId = $exceptId;
  }
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $admin = Admin::where('admin_id', $value)->where('id', '!=', $this->exceptId)->exists();
    $teacher = Teacher::where('teacher_id', $value)->where('id', '!=', $this->exceptId)->exists();
    $student = Student::where('student_id', $value)->where('id', '!=', $this->exceptId)->exists();

    if ($admin || $teacher || $student) {
      $fail('The user Id has already been taken.');
    }
  }
}
