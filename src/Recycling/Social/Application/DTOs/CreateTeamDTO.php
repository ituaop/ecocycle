<?php

namespace Src\Recycling\Social\Application\DTOs;

readonly class CreateTeamDTO
{
    public function __construct(
        private ?string $id,
        private string  $name,
        private string  $slug,
        private ?string $description,
        private string  $emoji      = '♻️',
        private string  $badgeColor = '#2d6a4f',
        private string  $ownerId    = '',
        private bool    $isPublic   = true,
        private int     $maxMembers = 20,
    ) {}

    public function getId(): ?string          { return $this->id; }
    public function getName(): string         { return $this->name; }
    public function getSlug(): string         { return $this->slug; }
    public function getDescription(): ?string { return $this->description; }
    public function getEmoji(): string        { return $this->emoji; }
    public function getBadgeColor(): string   { return $this->badgeColor; }
    public function getOwnerId(): string      { return $this->ownerId; }
    public function getIsPublic(): bool       { return $this->isPublic; }
    public function getMaxMembers(): int      { return $this->maxMembers; }
}
