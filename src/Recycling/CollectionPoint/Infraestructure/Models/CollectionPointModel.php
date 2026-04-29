<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPointModel extends Model
{
    protected $table        = 'collection_points';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'address',
        'latitude',
        'longitude',
        'status',
        'schedule',
        'accepted_categories',
    ];

    public $timestamps = true;
}
