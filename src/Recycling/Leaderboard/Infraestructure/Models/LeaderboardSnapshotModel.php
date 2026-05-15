<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class LeaderboardSnapshotModel extends Model
{
    protected $table        = 'leaderboard_snapshots';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'user_id', 'period_type', 'period_key',
        'points', 'position', 'level',
    ];

    protected $casts = [
        'points'   => 'integer',
        'position' => 'integer',
    ];

    public $timestamps = true;
}
