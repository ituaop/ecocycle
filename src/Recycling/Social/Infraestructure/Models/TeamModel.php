<?php

namespace Src\Recycling\Social\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class TeamModel extends Model
{
    protected $table        = 'teams';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'name', 'slug', 'description', 'emoji',
        'badge_color', 'owner_id', 'is_public', 'max_members', 'total_points',
    ];

    protected $casts = [
        'is_public'    => 'boolean',
        'max_members'  => 'integer',
        'total_points' => 'integer',
    ];

    public $timestamps = true;
}
