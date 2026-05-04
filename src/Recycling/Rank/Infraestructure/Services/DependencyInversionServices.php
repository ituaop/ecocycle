<?php

namespace Src\Recycling\Rank\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Application\Services\RankResolverService;
use Src\Recycling\Rank\Infraestructure\Repositories\EloquentRankRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        // Puerto → implementación Eloquent
        $this->app->bind(
            RankRepositoryPort::class,
            EloquentRankRepository::class
        );

        // RankResolverService como singleton para reutilizar caché en memoria
        $this->app->singleton(RankResolverService::class, function ($app) {
            return new RankResolverService(
                $app->make(RankRepositoryPort::class)
            );
        });
    }
}
