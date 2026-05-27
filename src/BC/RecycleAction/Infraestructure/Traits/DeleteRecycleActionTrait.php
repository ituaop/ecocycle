<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Traits;

use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;
use Src\Recycling\RecycleAction\Infraestructure\Models\RecycleActionModel;

trait DeleteRecycleActionTrait
{
    public function delete(RecycleActionId $id): void
    {
        $model = RecycleActionModel::find($id->value());
        if ($model) {
            $model->delete();
        }
    }
}
