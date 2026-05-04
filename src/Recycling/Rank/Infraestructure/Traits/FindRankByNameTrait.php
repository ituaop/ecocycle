<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Infraestructure\Hydrators\RankHydrator;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait FindRankByNameTrait
{
    public function findByName(string $name): ?Rank
    {
        $model = RankModel::where('name', strtoupper($name))->first();
        return $model ? RankHydrator::toDomain($model) : null;
    }
}
