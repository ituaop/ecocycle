<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Traits;

use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Infraestructure\Models\CollectionPointModel;

trait UpdateCollectionPointTrait
{
    public function update(CollectionPoint $cp): void
    {
        $model = CollectionPointModel::find($cp->getIdValue());
        if ($model) {
            $model->update([
                'name'      => $cp->getNameValue(),
                'address'   => $cp->getAddressValue(),
                'latitude'  => $cp->getLatitudeValue(),
                'longitude' => $cp->getLongitudeValue(),
                'status'    => $cp->getStatusValue(),
            ]);
        }
    }
}
