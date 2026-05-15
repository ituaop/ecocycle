<?php

namespace Src\Recycling\Leaderboard\Application\UseCases;

use Src\Recycling\Leaderboard\Application\Ports\LeaderboardRepositoryPort;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;

class GetUserLeaderboardPositionUseCase
{
    public function __construct(private LeaderboardRepositoryPort $repository) {}

    public function execute(string $userId, string $period): int
    {
        return $this->repository->getUserPosition(
            new LeaderboardUserId($userId),
            $period
        );
    }
}
