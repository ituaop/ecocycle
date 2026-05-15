<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Repositories;

use Src\Recycling\Leaderboard\Application\Ports\LeaderboardRepositoryPort;
use Src\Recycling\Leaderboard\Infraestructure\Traits\GetLiveRankingTrait;
use Src\Recycling\Leaderboard\Infraestructure\Traits\GetUserHistoryTrait;
use Src\Recycling\Leaderboard\Infraestructure\Traits\GetUserPositionTrait;
use Src\Recycling\Leaderboard\Infraestructure\Traits\SaveSnapshotTrait;

class EloquentLeaderboardRepository implements LeaderboardRepositoryPort
{
    use GetLiveRankingTrait,
        GetUserPositionTrait,
        SaveSnapshotTrait,
        GetUserHistoryTrait;
}

