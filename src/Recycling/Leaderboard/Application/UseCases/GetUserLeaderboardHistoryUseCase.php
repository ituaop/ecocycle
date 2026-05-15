<?php

namespace Src\Recycling\Leaderboard\Application\UseCases;

use Src\Recycling\Leaderboard\Application\Ports\LeaderboardRepositoryPort;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;

class GetUserLeaderboardHistoryUseCase
{
    public function __construct(private LeaderboardRepositoryPort $repository) {}

    public function execute(string $userId, string $period): array
    {
        return $this->repository->getUserHistory(
            new LeaderboardUserId($userId),
            $period
        );
    }
}
