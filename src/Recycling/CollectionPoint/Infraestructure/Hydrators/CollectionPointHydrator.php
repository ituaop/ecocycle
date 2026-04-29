<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Hydrators;

use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAcceptedCategories;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAddress;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLatitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLongitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointName;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointSchedule;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointStatus;
use Src\Recycling\CollectionPoint\Infraestructure\Models\CollectionPointModel;

class CollectionPointHydrator
{
    public static function toDomain(CollectionPointModel $model): CollectionPoint
    {
        return new CollectionPoint(
            new CollectionPointId($model->id),
            new CollectionPointName($model->name),
            new CollectionPointAddress($model->address),
            new CollectionPointLatitude((float) $model->latitude),
            new CollectionPointLongitude((float) $model->longitude),
            new CollectionPointStatus($model->status),
            new CollectionPointSchedule($model->schedule),
            new CollectionPointAcceptedCategories($model->accepted_categories ?? '[]')
        );
    }
}
