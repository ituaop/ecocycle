<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Traits;

use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;
use Src\Recycling\CollectionPoint\Infraestructure\Models\CollectionPointModel;

trait DeleteCollectionPointTrait
{
    public function delete(CollectionPointId $id): void
    {
        $model = CollectionPointModel::find($id->value());
        if ($model) {
            $model->delete();
        }
    }
}
