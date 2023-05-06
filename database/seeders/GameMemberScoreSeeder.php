<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameMember;
use App\Models\GameMemberScore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameMemberScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = Game::all();
        foreach ($games as $game) {
            $members = $game->members()->get();
            foreach ($members as $member) {
                $scores = rand(1, 100); // generate random scores for each member
                $gameMember = GameMember::where('game_id', $game->id)->where('member_id', $member->id)->first();
                if (!$gameMember) {
                    // if game member entry does not exist, create it
                    $gameMember = GameMember::create([
                        'game_id' => $game->id,
                        'member_id' => $member->id,
                        'member_total_score' => $scores,
                    ]);
                } else {
                    // if game member entry already exists, update total score
                    $gameMember->member_total_score += $scores;
                    $gameMember->save();
                }

                // create game member score entry
                GameMemberScore::create([
                    'game_member_id' => $gameMember->id,
                    'score' => $scores,
                    'scored_at' => now()
                ]);
            }

            // calculate total game score
            $gameMemberScores = $game->gameMemberScores()->get();
            $totalScore = $gameMemberScores->sum('score');

            $game->total_score = $totalScore;
            $game->save();


            // determine winner of the game
            $winning_member_id = $game->gameMembers()->orderBy('member_total_score', 'desc')->first();
            $game->winner_id = $winning_member_id->member_id;
            $game->save();
        }
    }
}
