<?php
namespace Src\Recycling\Leaderboard\Domain\Entities;

use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardEntryId;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardPeriodVO;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardPoints;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardPosition;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;

class LeaderboardEntry
{
    public function __construct(
        private LeaderboardEntryId  $id,
        private LeaderboardUserId   $userId,
        private LeaderboardPeriodVO $period,
        private string              $periodKey,
        private LeaderboardPoints   $points,
        private LeaderboardPosition $position,
        private string              $level,
    ) {}

    public function getId(): LeaderboardEntryId       { return $this->id; }
    public function getUserId(): LeaderboardUserId    { return $this->userId; }
    public function getPeriod(): LeaderboardPeriodVO  { return $this->period; }
    public function getPeriodKey(): string            { return $this->periodKey; }
    public function getPoints(): LeaderboardPoints    { return $this->points; }
    public function getPosition(): LeaderboardPosition{ return $this->position; }
    public function getLevel(): string               { return $this->level; }

    // Shortcuts
    public function getIdValue(): string        { return $this->id->value(); }
    public function getUserIdValue(): string    { return $this->userId->value(); }
    public function getPeriodValue(): string    { return $this->period->value(); }
    public function getPointsInt(): int         { return $this->points->value(); }
    public function getPositionInt(): int       { return $this->position->value(); }

    public function medalEmoji(): string
    {
        return match($this->getPositionInt()) {
            1 => '🥇', 2 => '🥈', 3 => '🥉',
            default => "#{$this->getPositionInt()}",
        };
    }
}