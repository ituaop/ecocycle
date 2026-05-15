<?php

namespace Src\Recycling\Social\Domain\Entities;

use Carbon\Carbon;
use Src\Recycling\Social\Domain\Enumerations\FeedEventType;
use Src\Recycling\Social\Domain\ValueObjects\FeedEntryId;
use Src\Recycling\Social\Domain\ValueObjects\FeedUserId;

class FeedEntry
{
    public function __construct(
        private FeedEntryId   $id,
        private FeedUserId    $userId,
        private ?string       $teamId,
        private FeedEventType $type,
        private string        $title,
        private ?string       $description,
        private string        $emoji,
        private int           $points,
        private array         $meta,
        private Carbon        $createdAt,
    ) {}

    public function getId(): FeedEntryId       { return $this->id; }
    public function getUserId(): FeedUserId    { return $this->userId; }
    public function getTeamId(): ?string       { return $this->teamId; }
    public function getType(): FeedEventType   { return $this->type; }
    public function getTitle(): string         { return $this->title; }
    public function getDescription(): ?string  { return $this->description; }
    public function getEmoji(): string         { return $this->emoji; }
    public function getPoints(): int           { return $this->points; }
    public function getMeta(): array           { return $this->meta; }
    public function getCreatedAt(): Carbon     { return $this->createdAt; }

    public function getIdValue(): string     { return $this->id->value(); }
    public function getUserIdValue(): string { return $this->userId->value(); }
    public function getTypeValue(): string   { return $this->type->value; }
}
