<?php

namespace Src\Recycling\WasteItem\Infraestructure\Traits;

use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;
use Src\Recycling\WasteItem\Infraestructure\Hydrators\WasteItemHydrator;
use Src\Recycling\WasteItem\Infraestructure\Models\WasteItemModel;

trait ReadWasteItemTrait
{
    public function read(WasteItemId $id): ?WasteItem
    {
        $model = WasteItemModel::find($id->value());
        return $model ? WasteItemHydrator::toDomain($model) : null;
    }
}
