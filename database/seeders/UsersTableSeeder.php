<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {
    DB::table('users')->insert([
      [
        'name' => 'Admin Disdikpora',
        'email' => 'parmahokkydrive@gmail.com',
        'username' => 'admin',
        'password' => Hash::make('admin123'),
      ],
    ]);
  }
}
