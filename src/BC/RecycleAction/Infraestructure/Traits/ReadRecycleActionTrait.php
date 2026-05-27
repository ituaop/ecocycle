<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Traits;

use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;
use Src\Recycling\RecycleAction\Infraestructure\Hydrators\RecycleActionHydrator;
use Src\Recycling\RecycleAction\Infraestructure\Models\RecycleActionModel;

trait ReadRecycleActionTrait
{
    public function read(RecycleActionId $id): ?RecycleAction
    {
        $model = RecycleActionModel::find($id->value());
        return $model ? RecycleActionHydrator::toDomain($model) : null;
    }
}
