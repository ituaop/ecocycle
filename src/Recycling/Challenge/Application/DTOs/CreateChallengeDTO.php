<?php

namespace Src\Recycling\Challenge\Application\DTOs;

readonly class CreateChallengeDTO
{
    public function __construct(
        private ?string $id,
        private string  $title,
        private ?string $description,
        private string  $emoji,
        private string  $type,
        private string  $category,
        private int     $targetValue,
        private int     $bonusPoints,
        private string  $badgeColor  = '#2d6a4f',
        private bool    $isActive    = true,
        private string  $startsAt    = '',
        private string  $endsAt      = '',
    ) {}

    public function getId(): ?string          { return $this->id; }
    public function getTitle(): string        { return $this->title; }
    public function getDescription(): ?string { return $this->description; }
    public function getEmoji(): string        { return $this->emoji; }
    public function getType(): string         { return $this->type; }
    public function getCategory(): string     { return $this->category; }
    public function getTargetValue(): int     { return $this->targetValue; }
    public function getBonusPoints(): int     { return $this->bonusPoints; }
    public function getBadgeColor(): string   { return $this->badgeColor; }
    public function getIsActive(): bool       { return $this->isActive; }
    public function getStartsAt(): string     { return $this->startsAt; }
    public function getEndsAt(): string       { return $this->endsAt; }
}
