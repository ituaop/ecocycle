<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\ValueObjects\RankId;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait DeleteRankTrait
{
    public function delete(RankId $id): void
    {
        $model = RankModel::find($id->value());
        if ($model) {
            $model->delete();
        }
    }
}
