<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
          'name' => 'Spaceship',
          'state' => 0
        ]);
        DB::table('rooms')->insert([
          'name' => 'Airport',
          'state' => 0
        ]);
        DB::table('rooms')->insert([
          'name' => 'Pyongyang',
          'state' => 0
        ]);
        DB::table('rooms')->insert([
          'name' => 'Oa',
          'state' => 0
        ]);
        DB::table('rooms')->insert([
          'name' => 'Central City',
          'state' => 0
        ]);
        DB::table('rooms')->insert([
          'name' => 'Azarath',
          'state' => 0
        ]);
        DB::table('rooms')->insert([
          'name' => 'Tamaran',
          'state' => 0
        ]);
    }
}
