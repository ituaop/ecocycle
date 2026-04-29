<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class RecycleActionModel extends Model
{
    protected $table        = 'recycle_actions';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'waste_item_id',
        'collection_point_id',
        'quantity',
        'date',
        'points_earned',
        'level_before',
        'level_after',
        'level_up',
    ];

    protected $casts = [
        'quantity'      => 'integer',
        'points_earned' => 'integer',
        'level_up'      => 'boolean',
    ];

    public $timestamps = true;
}
