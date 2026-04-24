<?php

namespace Src\Recycling\User\Infraestructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserModel extends Authenticatable
{
    use HasUuids;
    protected $table      = 'recycling_users';
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public    $incrementing = false;

protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'password',
        'level',
        'total_points',
    ];

    public $timestamps = true;
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'total_points'      => 'integer',
    ];
}
