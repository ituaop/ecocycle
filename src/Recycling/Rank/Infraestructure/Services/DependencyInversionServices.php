<?php

namespace Src\Recycling\Rank\Infraestructure\Services;


use Illuminate\Support\ServiceProvider;
use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;
use Src\Recycling\Rank\Infraestructure\Repositories\EloquentRankRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RankRepositoryPort::class,
            EloquentRankRepository::class
        );
   
    $this->app->bind(
            'auth.model',
            fn() => new RankModel()
        );
         }
}
