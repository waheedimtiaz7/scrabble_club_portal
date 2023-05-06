<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        for ($i = 1; $i <= 100; $i++) {
            DB::table('games')->insert([
                'date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'game_duration_in_minutes' => rand(30, 200),
                'status' => 'completed'
            ]);
        }
    }
}
