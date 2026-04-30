<?php

namespace Src\Recycling\User\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\User\Application\Ports\AuthUserRepositoryPort;
use Src\Recycling\User\Infraestructure\Repositories\EloquentAuthUserRepository;

/**
 * Service Provider para el flujo de autenticación (registro y login).
 * Vincula el puerto AuthUserRepositoryPort con su implementación Eloquent.
 */
class AuthDependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AuthUserRepositoryPort::class,
            EloquentAuthUserRepository::class
        );
    }
}
