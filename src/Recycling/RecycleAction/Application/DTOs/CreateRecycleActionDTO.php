<?php

namespace Src\Recycling\RecycleAction\Application\DTOs;

readonly class CreateRecycleActionDTO

{
    public function __construct(
        private ?string $id,
        private string  $userId,
        private string  $wasteItemId,
        private string  $collectionPointId,
        private int     $quantity,
        private string  $date,
        private int     $pointsEarned
    ) {}

    public function getId(): ?string              { return $this->id; }
    public function getUserId(): string           { return $this->userId; }
    public function getWasteItemId(): string      { return $this->wasteItemId; }
    public function getCollectionPointId(): string { return $this->collectionPointId; }
    public function getQuantity(): int            { return $this->quantity; }
    public function getDate(): string             { return $this->date; }
    public function getPointsEarned(): int        { return $this->pointsEarned; }
}
