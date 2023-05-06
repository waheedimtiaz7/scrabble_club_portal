<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMember extends Model
{
    use HasFactory;

    protected $table = 'game_member';

    protected $fillable = [
      'game_id',
      'member_id',
      'member_total_score'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function gameMemberScores()
    {
        return $this->hasMany(GameMemberScore::class)->onDelete(function ($gameMember) {
            $gameMember->gameMemberScores()->delete();
        });
    }
}
