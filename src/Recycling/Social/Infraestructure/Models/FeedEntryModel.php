<?php

namespace Src\Recycling\Social\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class FeedEntryModel extends Model
{
    protected $table        = 'activity_feed';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id', 'user_id', 'team_id', 'type',
        'title', 'description', 'emoji', 'points', 'meta',
    ];

    protected $casts = [
        'meta'   => 'array',
        'points' => 'integer',
    ];

    public $timestamps = true;
}