<?php

namespace Src\Recycling\Rank\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class RankModel extends Model
{
    protected $table    = 'ranks';
    protected $fillable = [
        'name',
        'label',
        'description',
        'badge_color',
        'badge_icon',
        'min_points',
        'max_points',
        'order',
    ];

    protected $casts = [
        'min_points' => 'integer',
        'max_points' => 'integer',
        'order'      => 'integer',
    ];

    public $timestamps = true;
}
