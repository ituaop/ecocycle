<?php
namespace Src\Recycling\Challenge\Domain\Entities;

use Carbon\Carbon;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeBadgeColor;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeBonusPoints;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeCategoryVO;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeEmoji;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeTargetValue;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeTitle;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeTypeVO;

class Challenge
{
    public function __construct(
        private ChallengeId          $id,
        private ChallengeTitle       $title,
        private ?string              $description,
        private ChallengeEmoji       $emoji,
        private ChallengeTypeVO      $type,
        private ChallengeCategoryVO  $category,
        private ChallengeTargetValue $targetValue,
        private ChallengeBonusPoints $bonusPoints,
        private ChallengeBadgeColor  $badgeColor,
        private bool                 $isActive,
        private Carbon               $startsAt,
        private Carbon               $endsAt,
    ) {}

    public function getId(): ChallengeId              { return $this->id; }
    public function getTitle(): ChallengeTitle        { return $this->title; }
    public function getDescription(): ?string         { return $this->description; }
    public function getEmoji(): ChallengeEmoji        { return $this->emoji; }
    public function getType(): ChallengeTypeVO        { return $this->type; }
    public function getCategory(): ChallengeCategoryVO{ return $this->category; }
    public function getTargetValue(): ChallengeTargetValue { return $this->targetValue; }
    public function getBonusPoints(): ChallengeBonusPoints { return $this->bonusPoints; }
    public function getBadgeColor(): ChallengeBadgeColor   { return $this->badgeColor; }
    public function isActive(): bool                  { return $this->isActive; }
    public function getStartsAt(): Carbon             { return $this->startsAt; }
    public function getEndsAt(): Carbon               { return $this->endsAt; }

    // Shortcuts
    public function getIdValue(): string          { return $this->id->value(); }
    public function getTitleValue(): string       { return $this->title->value(); }
    public function getEmojiValue(): string       { return $this->emoji->value(); }
    public function getTypeValue(): string        { return $this->type->value(); }
    public function getCategoryValue(): string    { return $this->category->value(); }
    public function getTargetValueInt(): int      { return $this->targetValue->value(); }
    public function getBonusPointsInt(): int      { return $this->bonusPoints->value(); }
    public function getBadgeColorValue(): string  { return $this->badgeColor->value(); }

    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->endsAt);
    }

    public function daysRemaining(): int
    {
        return max(0, (int) Carbon::now()->diffInDays($this->endsAt, false));
    }
}


