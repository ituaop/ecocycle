<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Traits;

use Src\Recycling\Leaderboard\Domain\Entities\LeaderboardEntry;
use Src\Recycling\Leaderboard\Infraestructure\Models\LeaderboardSnapshotModel;

trait SaveSnapshotTrait
{
    public function saveSnapshot(LeaderboardEntry $entry): void
    {
        LeaderboardSnapshotModel::updateOrCreate(
            [
                'user_id'     => $entry->getUserIdValue(),
                'period_type' => $entry->getPeriodValue(),
                'period_key'  => $entry->getPeriodKey(),
            ],
            [
                'id'       => $entry->getIdValue(),
                'points'   => $entry->getPointsInt(),
                'position' => $entry->getPositionInt(),
                'level'    => $entry->getLevel(),
            ]
        );
    }
}
