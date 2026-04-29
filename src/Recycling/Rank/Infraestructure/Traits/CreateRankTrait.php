<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait CreateRankTrait
{
    public function create(Rank $rank): void
    {
        RankModel::create([
            'name'        => $rank->getNameValue(),
            'label'       => $rank->getLabelValue(),
            'description' => $rank->getDescriptionValue(),
            'badge_color' => $rank->getBadgeColorValue(),
            'badge_icon'  => $rank->getBadgeIconValue(),
            'min_points'  => $rank->getMinPointsValue(),
            'max_points'  => $rank->getMaxPointsValue(),
            'order'       => $rank->getOrderValue(),
        ]);
    }
}
