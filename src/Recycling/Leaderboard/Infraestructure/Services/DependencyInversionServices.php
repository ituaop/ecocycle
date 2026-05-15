<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Recycling\Leaderboard\Application\Ports\LeaderboardRepositoryPort;
use Src\Recycling\Leaderboard\Infraestructure\Repositories\EloquentLeaderboardRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            LeaderboardRepositoryPort::class,
            EloquentLeaderboardRepository::class
        );
    }
}

