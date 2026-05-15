<?php

namespace Src\Recycling\Challenge\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class UserChallengeModel extends Model
{
    protected $table        = 'user_challenges';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'user_id', 'challenge_id',
        'current_value', 'completed', 'completed_at', 'reward_claimed',
    ];

    protected $casts = [
        'completed'      => 'boolean',
        'reward_claimed' => 'boolean',
        'completed_at'   => 'datetime',
    ];

    public $timestamps = true;
}


