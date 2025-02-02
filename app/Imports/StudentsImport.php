<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new Student([
      'student_id' => $row['student_id'],
      'username' => $row['username'],
      'fname' => $row['fname'],
      'lname' => $row['lname'],
      'email' => $row['email'],
      'password' => Hash::make($row['password']),
      'phone' => $row['phone'],
    ]);
  }
}
