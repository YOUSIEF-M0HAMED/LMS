<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'course_code' => 'required|unique:courses|max:255',
      'name' => 'required|max:255',
      'specification' => 'required',
      'logo' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
    ];
  }
}
