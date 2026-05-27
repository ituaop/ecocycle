<?php

namespace Src\Recycling\WasteItem\Infraestructure\Traits;

use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Infraestructure\Models\WasteItemModel;

trait UpdateWasteItemTrait
{
    public function update(WasteItem $item): void
    {
        $model = WasteItemModel::find($item->getIdValue());
        if ($model) {
            $model->update([
                'name'        => $item->getNameValue(),
                'description' => $item->getDescriptionValue(),
                'category'    => $item->getCategoryValue(),
                'points'      => $item->getPointsValue(),
            ]);
        }
    }
}
