<?php

namespace Src\Recycling\WasteItem\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class WasteItemModel extends Model
{
    protected $table        = 'waste_items';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'category',
        'points',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points'    => 'integer',
    ];

    public $timestamps = true;
}
