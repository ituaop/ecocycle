<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Hydrators;

use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionCollectionPointId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionDate;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionPointsEarned;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionQuantity;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionUserId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionWasteItemId;
use Src\Recycling\RecycleAction\Infraestructure\Models\RecycleActionModel;

class RecycleActionHydrator
{
    public static function toDomain(RecycleActionModel $model): RecycleAction
    {
        return new RecycleAction(
            new RecycleActionId($model->id),
            new RecycleActionUserId($model->user_id),
            new RecycleActionWasteItemId($model->waste_item_id),
            new RecycleActionCollectionPointId($model->collection_point_id),
            new RecycleActionQuantity((int) $model->quantity),
            new RecycleActionDate($model->date),
            new RecycleActionPointsEarned((int) $model->points_earned)
        );
    }
}
