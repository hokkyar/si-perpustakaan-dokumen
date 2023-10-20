<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('tokens')->insert([
      [
        'drive_refresh_token' => '1//04oRsyhRF1zHBCgYIARAAGAQSNwF-L9Ir_bxQCSw7mNgJWGgE9Q1wL2s2O6FU7W36e68LPMUGxx94JQGorU30DM9IKu28NacJkVY'
      ],
    ]);
  }
}
