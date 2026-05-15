<?php

namespace Src\Recycling\Challenge\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;
use Src\Recycling\Challenge\Infraestructure\Repositories\EloquentChallengeRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ChallengeRepositoryPort::class,
            EloquentChallengeRepository::class
        );
    }
}
