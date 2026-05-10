<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'id'                => $user->id,
                    'name'              => $user->name,
                    'username'          => $user->username,
                    'email'             => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'level'             => $user->level ?? 'BEGINNER',
                    'total_points'      => (int) ($user->total_points ?? 0),
                ] : null,
            ],
            'flash' => [
                'success' => session('success'),
                'error'   => session('error'),
                'status'  => session('status'),
            ],
        ];
    }
}
 