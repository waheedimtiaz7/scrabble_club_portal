<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'game_duration_in_minutes',
        'winner_id',
        'total_score',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

    public function gameMembers()
    {
        return $this->hasMany(GameMember::class);
    }

    public function winner()
    {
        return $this->belongsTo(Member::class,'winner_id');
    }

    public function gameMemberScores()
    {
        return $this->hasManyThrough(
            GameMemberScore::class,
            GameMember::class,
            'game_id', // Foreign key on GameMember table
            'game_member_id', // Foreign key on GameMemberScore table
            'id', // Local key on Game table
            'id' // Local key on GameMember table
        );
    }

    public function opponentOf(Member $member)
    {
        // Get the members of the game
        $members = $this->members;

        // Remove the given member from the list
        $members = $members->reject(function ($item) use ($member) {
            return $item->id == $member->id;
        });

        // Return the first member in the remaining list
        return $members->first();
    }
}
