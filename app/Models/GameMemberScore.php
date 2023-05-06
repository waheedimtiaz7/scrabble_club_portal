<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMemberScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_member_id',
        'score',
        'scored_at'
    ];

    public function gameMember(){
        return $this->belongsTo(GameMember::class,'game_member_id');
    }
}
