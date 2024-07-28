<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeacherSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $teacher = [
      'teacher_id' => '2024100',
      'username' => 't2024100',
      'fname' => 'teacher1',
      'lname' => 'teacher',
      'email' => 'teacher1@teacher.com',
      'password' => Hash::make('123123123'),
    ];

    DB::table('teachers')->insert($teacher);
  }
}
