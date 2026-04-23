<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Traits;

use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;
use Src\Recycling\CollectionPoint\Infraestructure\Hydrators\CollectionPointHydrator;
use Src\Recycling\CollectionPoint\Infraestructure\Models\CollectionPointModel;

trait ReadCollectionPointTrait
{
    public function read(CollectionPointId $id): ?CollectionPoint
    {
        $model = CollectionPointModel::find($id->value());
        return $model ? CollectionPointHydrator::toDomain($model) : null;
    }
}
