<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameMember;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = Game::all();

        foreach ($games as $game) {
            $memberCount = rand(2, 4);
            $members = Member::inRandomOrder()->take($memberCount)->get();

            foreach ($members as $member) {
                $game->members()->attach($member->id);
            }
        }
    }
}
