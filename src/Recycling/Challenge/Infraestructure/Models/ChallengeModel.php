<?php

namespace Src\Recycling\Challenge\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeModel extends Model
{
    protected $table        = 'challenges';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'title', 'description', 'emoji', 'type', 'category',
        'target_value', 'bonus_points', 'badge_color', 'is_active',
        'starts_at', 'ends_at',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'starts_at'  => 'date',
        'ends_at'    => 'date',
    ];

    public $timestamps = true;
}
