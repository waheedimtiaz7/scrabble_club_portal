<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\GameMember;
use App\Models\GameMemberScore;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MemberSeeder::class,
            GameSeeder::class,
            GameMemberSeeder::class,
            GameMemberScoreSeeder::class
        ]);
    }
}
