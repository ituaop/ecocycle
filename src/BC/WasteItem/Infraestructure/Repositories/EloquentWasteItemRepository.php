<?php

namespace Src\Recycling\WasteItem\Infraestructure\Repositories;

use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;
use Src\Recycling\WasteItem\Infraestructure\Traits\CreateWasteItemTrait;
use Src\Recycling\WasteItem\Infraestructure\Traits\DeleteWasteItemTrait;
use Src\Recycling\WasteItem\Infraestructure\Traits\GetAllWasteItemsTrait;
use Src\Recycling\WasteItem\Infraestructure\Traits\ReadWasteItemTrait;
use Src\Recycling\WasteItem\Infraestructure\Traits\UpdateWasteItemTrait;

class EloquentWasteItemRepository implements WasteItemRepositoryPort
{
    use CreateWasteItemTrait,
        ReadWasteItemTrait,
        UpdateWasteItemTrait,
        DeleteWasteItemTrait,
        GetAllWasteItemsTrait;
}
