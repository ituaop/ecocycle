<?php

namespace Src\Recycling\RecycleAction\Domain\Entities;

use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionCollectionPointId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionDate;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionPointsEarned;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionQuantity;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionUserId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionWasteItemId;

class RecycleAction
{
    private RecycleActionId              $id;
    private RecycleActionUserId          $userId;
    private RecycleActionWasteItemId     $wasteItemId;
    private RecycleActionCollectionPointId $collectionPointId;
    private RecycleActionQuantity        $quantity;
    private RecycleActionDate            $date;
    private RecycleActionPointsEarned    $pointsEarned;

    public function __construct(
        RecycleActionId              $id,
        RecycleActionUserId          $userId,
        RecycleActionWasteItemId     $wasteItemId,
        RecycleActionCollectionPointId $collectionPointId,
        RecycleActionQuantity        $quantity,
        RecycleActionDate            $date,
        RecycleActionPointsEarned    $pointsEarned
    ) {
        $this->id                = $id;
        $this->userId            = $userId;
        $this->wasteItemId       = $wasteItemId;
        $this->collectionPointId = $collectionPointId;
        $this->quantity          = $quantity;
        $this->date              = $date;
        $this->pointsEarned      = $pointsEarned;
    }

    public function getId(): RecycleActionId                        { return $this->id; }
    public function getIdValue(): string                            { return $this->id->value(); }

    public function getUserId(): RecycleActionUserId                { return $this->userId; }
    public function getUserIdValue(): string                        { return $this->userId->value(); }

    public function getWasteItemId(): RecycleActionWasteItemId      { return $this->wasteItemId; }
    public function getWasteItemIdValue(): string                   { return $this->wasteItemId->value(); }

    public function getCollectionPointId(): RecycleActionCollectionPointId { return $this->collectionPointId; }
    public function getCollectionPointIdValue(): string             { return $this->collectionPointId->value(); }

    public function getQuantity(): RecycleActionQuantity            { return $this->quantity; }
    public function getQuantityValue(): int                         { return $this->quantity->value(); }

    public function getDate(): RecycleActionDate                    { return $this->date; }
    public function getDateValue(): string                          { return $this->date->value(); }

    public function getPointsEarned(): RecycleActionPointsEarned   { return $this->pointsEarned; }
    public function getPointsEarnedValue(): int                    { return $this->pointsEarned->value(); }
}
