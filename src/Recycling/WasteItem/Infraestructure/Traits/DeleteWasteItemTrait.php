<?php

namespace Src\Recycling\WasteItem\Infraestructure\Traits;

use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;
use Src\Recycling\WasteItem\Infraestructure\Models\WasteItemModel;

trait DeleteWasteItemTrait
{
    public function delete(WasteItemId $id): void
    {
        $model = WasteItemModel::find($id->value());
        if ($model) {
            $model->delete();
        }
    }
}
