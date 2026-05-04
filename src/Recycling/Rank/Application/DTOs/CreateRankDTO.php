<?php

namespace Src\Recycling\Rank\Application\DTOs;

readonly class CreateRankDTO
{
    public function __construct(
        private ?int    $id,
        private string  $name,
        private string  $label,
        private string  $description,
        private string  $badgeColor,
        private string  $badgeIcon,
        private int     $minPoints,
        private int     $maxPoints,
        private int     $order
    ) {}

    public function getId(): ?int          { return $this->id; }
    public function getName(): string      { return $this->name; }
    public function getLabel(): string     { return $this->label; }
    public function getDescription(): string { return $this->description; }
    public function getBadgeColor(): string  { return $this->badgeColor; }
    public function getBadgeIcon(): string   { return $this->badgeIcon; }
    public function getMinPoints(): int    { return $this->minPoints; }
    public function getMaxPoints(): int    { return $this->maxPoints; }
    public function getOrder(): int        { return $this->order; }
}