<?php

namespace Src\Recycling\WasteItem\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class WasteItemModel extends Model
{
    protected $table      = 'waste_items';
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'category',
        'points',
    ];

    public $timestamps = true;
}
