<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;
use Src\Recycling\Rank\Infraestructure\Hydrators\RankHydrator;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait ReadRankTrait
{
    public function read(RankId $id): ?Rank
    {
        $model = RankModel::find($id->value());
        return $model ? RankHydrator::toDomain($model) : null;
    }
}
