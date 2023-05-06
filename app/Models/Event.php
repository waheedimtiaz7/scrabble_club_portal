<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_type', 'aggregate_id', 'payload', 'old_payload'
    ];
    protected $casts = [
        'payload' => 'json',
        'old_payload' => 'json',
    ];
}
