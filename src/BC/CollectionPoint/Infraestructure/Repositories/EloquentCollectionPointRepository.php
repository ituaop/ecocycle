<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Repositories;

use Src\Recycling\CollectionPoint\Application\Ports\CollectionPointRepositoryPort;
use Src\Recycling\CollectionPoint\Infraestructure\Traits\CreateCollectionPointTrait;
use Src\Recycling\CollectionPoint\Infraestructure\Traits\DeleteCollectionPointTrait;
use Src\Recycling\CollectionPoint\Infraestructure\Traits\GetAllCollectionPointsTrait;
use Src\Recycling\CollectionPoint\Infraestructure\Traits\ReadCollectionPointTrait;
use Src\Recycling\CollectionPoint\Infraestructure\Traits\UpdateCollectionPointTrait;

class EloquentCollectionPointRepository implements CollectionPointRepositoryPort
{
    use CreateCollectionPointTrait,
        ReadCollectionPointTrait,
        UpdateCollectionPointTrait,
        DeleteCollectionPointTrait,
        GetAllCollectionPointsTrait;
}
