<?php

namespace Src\Recycling\User\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\User\Application\Ports\AuthUserRepositoryPort;
use Src\Recycling\User\Infraestructure\Repositories\EloquentAuthUserRepository;


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
