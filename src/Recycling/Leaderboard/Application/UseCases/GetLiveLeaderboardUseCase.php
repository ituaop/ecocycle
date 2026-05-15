<?php

namespace Src\Recycling\Leaderboard\Application\UseCases;

use Src\Recycling\Leaderboard\Application\Ports\LeaderboardRepositoryPort;

class GetLiveLeaderboardUseCase
{
    public function __construct(private LeaderboardRepositoryPort $repository) {}

    public function execute(string $period, int $limit = 50): array
    {
        return $this->repository->getLiveRanking($period, $limit);
    }
}
