<?php

namespace Src\Recycling\WasteItem\Infraestructure\Traits;

use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Infraestructure\Models\WasteItemModel;

trait CreateWasteItemTrait
{
    public function create(WasteItem $item): void
    {
        WasteItemModel::create([
            'id'          => $item->getIdValue(),
            'name'        => $item->getNameValue(),
            'description' => $item->getDescriptionValue(),
            'category'    => $item->getCategoryValue(),
            'points'      => $item->getPointsValue(),
        ]);
    }
}
