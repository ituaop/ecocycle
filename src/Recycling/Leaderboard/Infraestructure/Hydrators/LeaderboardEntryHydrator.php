<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Hydrators;

use Src\Recycling\Leaderboard\Domain\Entities\LeaderboardEntry;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardEntryId;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardPeriodVO;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardPoints;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardPosition;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;
use Src\Recycling\Leaderboard\Infraestructure\Models\LeaderboardSnapshotModel;

class LeaderboardEntryHydrator
{
    public static function toDomain(LeaderboardSnapshotModel $m): LeaderboardEntry
    {
        return new LeaderboardEntry(
            new LeaderboardEntryId($m->id),
            new LeaderboardUserId($m->user_id),
            new LeaderboardPeriodVO($m->period_type),
            $m->period_key,
            new LeaderboardPoints((int) $m->points),
            new LeaderboardPosition((int) $m->position),
            $m->level,
        );
    }
}


