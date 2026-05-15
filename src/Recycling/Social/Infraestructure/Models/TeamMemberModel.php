<?php

namespace Src\Recycling\Social\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMemberModel extends Model
{
    protected $table        = 'team_members';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'team_id', 'user_id', 'role', 'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public $timestamps = true;
}

