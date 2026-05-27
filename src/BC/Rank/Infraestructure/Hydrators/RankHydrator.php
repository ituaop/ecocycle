<?php

namespace Src\Recycling\Rank\Infraestructure\Hydrators;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Domain\ValueObjects\RankBadgeColor;
use Src\Recycling\Rank\Domain\ValueObjects\RankBadgeIcon;
use Src\Recycling\Rank\Domain\ValueObjects\RankDescription;
use Src\Recycling\Rank\Domain\ValueObjects\RankId;
use Src\Recycling\Rank\Domain\ValueObjects\RankLabel;
use Src\Recycling\Rank\Domain\ValueObjects\RankMaxPoints;
use Src\Recycling\Rank\Domain\ValueObjects\RankMinPoints;
use Src\Recycling\Rank\Domain\ValueObjects\RankName;
use Src\Recycling\Rank\Domain\ValueObjects\RankOrder;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

class RankHydrator
{

    public static function toDomain(RankModel $model): Rank
    {
        return new Rank(
            new RankId((int) $model->id),
            new RankName($model->name),
            new RankLabel($model->label),
            new RankDescription($model->description),
            new RankBadgeColor($model->badge_color),
            new RankBadgeIcon($model->badge_icon),
            new RankMinPoints((int) $model->min_points),
            new RankMaxPoints((int) $model->max_points),
            new RankOrder((int) $model->order)
        );
    }
}
