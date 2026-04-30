<?php

namespace Src\Recycling\User\Infraestructure\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo Eloquent para autenticación con Laravel.
 * Extiende Authenticatable para que Auth::login(), Auth::user(), etc. funcionen.
 * Apunta a la misma tabla que UserModel (recycling_users).
 */
class UserAuthModel extends Authenticatable
{
    use Notifiable;

    protected $table        = 'recycling_users';
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'total_points'      => 'integer',
    ];

    public $timestamps = true;
}
