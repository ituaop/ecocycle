<?php
namespace Src\Recycling\Challenge\Domain\Entities;

use Carbon\Carbon;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeCurrentValue;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;

class UserChallenge
{
    public function __construct(
        private UserChallengeId           $id,
        private UserChallengeUserId       $userId,
        private ChallengeId               $challengeId,
        private UserChallengeCurrentValue $currentValue,
        private bool                      $completed,
        private ?Carbon                   $completedAt,
        private bool                      $rewardClaimed,
    ) {}

    public function getId(): UserChallengeId                   { return $this->id; }
    public function getUserId(): UserChallengeUserId           { return $this->userId; }
    public function getChallengeId(): ChallengeId              { return $this->challengeId; }
    public function getCurrentValue(): UserChallengeCurrentValue { return $this->currentValue; }
    public function isCompleted(): bool                        { return $this->completed; }
    public function getCompletedAt(): ?Carbon                  { return $this->completedAt; }
    public function isRewardClaimed(): bool                    { return $this->rewardClaimed; }

    // Shortcuts
    public function getIdValue(): string           { return $this->id->value(); }
    public function getUserIdValue(): string       { return $this->userId->value(); }
    public function getChallengeIdValue(): string  { return $this->challengeId->value(); }
    public function getCurrentValueInt(): int      { return $this->currentValue->value(); }

    public function progressPercent(int $target): int
    {
        if ($target <= 0) return 0;
        return min(100, (int) round(($this->getCurrentValueInt() / $target) * 100));
    }
}