<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Traits;

use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;
use Src\Recycling\Leaderboard\Infraestructure\Hydrators\LeaderboardEntryHydrator;
use Src\Recycling\Leaderboard\Infraestructure\Models\LeaderboardSnapshotModel;

trait GetUserHistoryTrait
{
    public function getUserHistory(LeaderboardUserId $userId, string $period): array
    {
        return LeaderboardSnapshotModel::where('user_id', $userId->value())
            ->where('period_type', $period)
            ->orderByDesc('period_key')
            ->limit(12)
            ->get()
            ->map(fn($m) => LeaderboardEntryHydrator::toDomain($m))
            ->all();
    }
}
