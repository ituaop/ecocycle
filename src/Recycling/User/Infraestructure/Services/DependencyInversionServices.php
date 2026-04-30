<?php

namespace Src\Recycling\User\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Infraestructure\Repositories\EloquentUserRepository;

/**
 * Service Provider para operaciones CRUD generales del usuario.
 */
class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryPort::class,
            EloquentUserRepository::class
        );
    }
}
