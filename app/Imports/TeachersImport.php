<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToModel, WithHeadingRow
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new Teacher([
      'teacher_id' => $row['teacher_id'],
      'username' => $row['username'],
      'fname' => $row['fname'],
      'lname' => $row['lname'],
      'email' => $row['email'],
      'password' => Hash::make($row['password']),
      'phone' => $row['phone'],
    ]);
  }
}
