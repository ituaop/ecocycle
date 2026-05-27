<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Traits;

use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Infraestructure\Models\CollectionPointModel;

trait CreateCollectionPointTrait
{
    public function create(CollectionPoint $cp): void
    {
        CollectionPointModel::create([
            'id'                  => $cp->getIdValue(),
            'name'                => $cp->getNameValue(),
            'address'             => $cp->getAddressValue(),
            'latitude'            => $cp->getLatitudeValue(),
            'longitude'           => $cp->getLongitudeValue(),
            'status'              => $cp->getStatusValue(),
            'schedule'            => $cp->getScheduleValue(),
            'accepted_categories' => $cp->getAcceptedCategoriesJson(),
        ]);
    }
}
