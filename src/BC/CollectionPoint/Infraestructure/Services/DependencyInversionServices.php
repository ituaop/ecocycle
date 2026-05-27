<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;
use Src\Recycling\CollectionPoint\Infraestructure\Repositories\EloquentCollectionPointRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CollectionPointRepositoryPort::class,
            EloquentCollectionPointRepository::class
        );
    }
}
