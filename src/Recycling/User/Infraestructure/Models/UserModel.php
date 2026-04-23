<?php

namespace Src\Recycling\User\Infraestructure\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table      = 'recycling_users';
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public    $incrementing = false;

    protected $fillable = [
        'id',
        'username',
        'email',
        'level',
        'total_points',
    ];

    public $timestamps = true;
}
