<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Traits;

use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Infraestructure\Models\RecycleActionModel;

trait CreateRecycleActionTrait
{
    public function create(RecycleAction $action): void
    {
        RecycleActionModel::create([
            'id'                  => $action->getIdValue(),
            'user_id'             => $action->getUserIdValue(),
            'waste_item_id'       => $action->getWasteItemIdValue(),
            'collection_point_id' => $action->getCollectionPointIdValue(),
            'quantity'            => $action->getQuantityValue(),
            'date'                => $action->getDateValue(),
            'points_earned'       => $action->getPointsEarnedValue(),
        ]);
    }
}
