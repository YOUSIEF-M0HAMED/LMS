<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $admin = [
      'admin_id' => '2024001',
      'username' => 'a2024001',
      'fname' => 'admin1',
      'lname' => 'admin',
      'email' => 'admin1@admin.com',
      'password' => Hash::make('123123123'),
    ];

    DB::table('admins')->insert($admin);
  }
}
