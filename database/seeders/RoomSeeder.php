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
          'name' => 'Spaceship'
        ]);
        DB::table('rooms')->insert([
          'name' => 'Airport'
        ]);
        DB::table('rooms')->insert([
          'name' => 'Pyongyang'
        ]);
        DB::table('rooms')->insert([
          'name' => 'Oa'
        ]);
        DB::table('rooms')->insert([
          'name' => 'Central City'
        ]);
        DB::table('rooms')->insert([
          'name' => 'Azarath'
        ]);
        DB::table('rooms')->insert([
          'name' => 'Tamaran'
        ]);
    }
}
