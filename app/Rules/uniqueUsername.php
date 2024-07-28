<?php

namespace App\Rules;

use Closure;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Contracts\Validation\ValidationRule;

class uniqueUsername implements ValidationRule
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
    $admin = Admin::where('username', $value)->where('id', '!=', $this->exceptId)->exists();
    $teacher = Teacher::where('username', $value)->where('id', '!=', $this->exceptId)->exists();
    $student = Student::where('username', $value)->where('id', '!=', $this->exceptId)->exists();

    if ($admin || $teacher || $student) {
      $fail('The username has already been taken.');
    }
  }
}
