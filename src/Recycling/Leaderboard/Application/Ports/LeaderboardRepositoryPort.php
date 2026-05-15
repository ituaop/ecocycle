<?php

namespace Src\Recycling\Leaderboard\Application\Ports;

use Src\Recycling\Leaderboard\Domain\Entities\LeaderboardEntry;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;

interface LeaderboardRepositoryPort
{
    public function getLiveRanking(string $period, int $limit = 50): array;

    public function getUserPosition(LeaderboardUserId $userId, string $period): int;

    public function saveSnapshot(LeaderboardEntry $entry): void;

    public function getUserHistory(LeaderboardUserId $userId, string $period): array;
}

