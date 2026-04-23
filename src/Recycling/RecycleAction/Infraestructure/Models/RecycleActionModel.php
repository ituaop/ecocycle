<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class RecycleActionModel extends Model
{
    protected $table      = 'recycle_actions';
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'waste_item_id',
        'collection_point_id',
        'quantity',
        'date',
        'points_earned',
    ];

    public $timestamps = true;
}
