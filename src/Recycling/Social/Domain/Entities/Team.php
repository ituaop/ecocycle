<?php

namespace Src\Recycling\Social\Domain\Entities;

use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Domain\ValueObjects\TeamName;
use Src\Recycling\Social\Domain\ValueObjects\TeamOwnerId;
use Src\Recycling\Social\Domain\ValueObjects\TeamSlug;

class Team
{
    public function __construct(
        private TeamId      $id,
        private TeamName    $name,
        private TeamSlug    $slug,
        private ?string     $description,
        private string      $emoji,
        private string      $badgeColor,
        private TeamOwnerId $ownerId,
        private bool        $isPublic,
        private int         $maxMembers,
        private int         $totalPoints,
    ) {}

    public function getId(): TeamId         { return $this->id; }
    public function getName(): TeamName     { return $this->name; }
    public function getSlug(): TeamSlug     { return $this->slug; }
    public function getDescription(): ?string { return $this->description; }
    public function getEmoji(): string      { return $this->emoji; }
    public function getBadgeColor(): string { return $this->badgeColor; }
    public function getOwnerId(): TeamOwnerId { return $this->ownerId; }
    public function isPublic(): bool        { return $this->isPublic; }
    public function getMaxMembers(): int    { return $this->maxMembers; }
    public function getTotalPoints(): int   { return $this->totalPoints; }

    public function getIdValue(): string      { return $this->id->value(); }
    public function getNameValue(): string    { return $this->name->value(); }
    public function getSlugValue(): string    { return $this->slug->value(); }
    public function getOwnerIdValue(): string { return $this->ownerId->value(); }
}
