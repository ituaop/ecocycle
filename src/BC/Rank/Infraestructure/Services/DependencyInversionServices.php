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
        $this->app->bind(
            RankRepositoryPort::class,
            EloquentRankRepository::class
        );

        $this->app->singleton(RankResolverService::class, function ($app) {
            return new RankResolverService(
                $app->make(RankRepositoryPort::class)
            );
        });
    }
}
