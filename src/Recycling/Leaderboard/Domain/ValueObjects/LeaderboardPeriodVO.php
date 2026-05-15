<?php

namespace Src\Recycling\Leaderboard\Domain\ValueObjects;

use Src\Recycling\Leaderboard\Domain\Enumerations\LeaderboardPeriod;

class LeaderboardPeriodVO
{
    private LeaderboardPeriod $period;

    public function __construct(string $period)
    {
        $this->period = LeaderboardPeriod::from($period);
    }

    public function value(): string              { return $this->period->value; }
    public function label(): string              { return $this->period->label(); }
    public function emoji(): string              { return $this->period->emoji(); }
    public function currentKey(): string         { return $this->period->currentKey(); }
    public function enum(): LeaderboardPeriod    { return $this->period; }
}
