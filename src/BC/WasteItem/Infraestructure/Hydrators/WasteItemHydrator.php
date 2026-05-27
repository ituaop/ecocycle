<?php

namespace Src\Recycling\WasteItem\Infraestructure\Hydrators;

use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemCategory;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemDescription;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemName;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemPoints;
use Src\Recycling\WasteItem\Infraestructure\Models\WasteItemModel;

class WasteItemHydrator
{
    public static function toDomain(WasteItemModel $model): WasteItem
    {
        return new WasteItem(
            new WasteItemId($model->id),
            new WasteItemName($model->name),
            new WasteItemDescription($model->description),
            new WasteItemCategory($model->category),
            new WasteItemPoints((int) $model->points)
        );
    }
}
