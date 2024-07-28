<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $student = [
      'student_id' => '2024500',
      'username' => 's2024500',
      'fname' => 'student1',
      'lname' => 'student',
      'email' => 'student1@student.com',
      'password' => Hash::make('123123123'),
      
    ];

    DB::table('students')->insert($student);
  }
}
