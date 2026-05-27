<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;
use Src\Recycling\RecycleAction\Infraestructure\Repositories\EloquentRecycleActionRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RecycleActionRepositoryPort::class,
            EloquentRecycleActionRepository::class
        );
    }
}
