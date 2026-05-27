<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Infraestructure\Hydrators\RankHydrator;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait GetAllRanksTrait
{
    /** @return Rank[] */
    public function getAllRanks(): array
    {
        return RankModel::orderBy('order')
            ->get()
            ->map(fn(RankModel $m) => RankHydrator::toDomain($m))
            ->all();
    }
}
