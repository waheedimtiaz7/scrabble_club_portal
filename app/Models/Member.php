<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EventSourcing;

class Member extends Model
{
    use HasFactory, SoftDeletes, EventSourcing;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'joining_date',
    ];


    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function gameMember()
    {
        return $this->hasMany(GameMember::class,'member_id');
    }
}
