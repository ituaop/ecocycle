<?php

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'recycling_users',
    ],

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'recycling_users',
        ],
    ],

    'providers' => [
        'recycling_users' => [
            'driver' => 'eloquent',
            // ← Cambiar App\Models\User por:
            'model'  => \Src\Recycling\User\Infraestructure\Models\UserAuthModel::class,
        ],
    ],

    'passwords' => [
        'recycling_users' => [
            'provider' => 'recycling_users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
 