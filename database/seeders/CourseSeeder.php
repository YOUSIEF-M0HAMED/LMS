<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $course = [
      'course_code' => 'SCE123',
      'name' => 'Software Engineering',
      'specification' => 'Software engineering involves applying engineering principles to the design, development, testing, and maintenance of software systems to ensure functionality, reliability, and scalability',
      'logo' => 'courses/course.jpeg',
    ];

    DB::table('courses')->insert($course);
  }
}
