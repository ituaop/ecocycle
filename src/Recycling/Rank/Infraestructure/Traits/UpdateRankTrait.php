<?php

namespace Src\Recycling\Rank\Infraestructure\Traits;

use Src\Recycling\Rank\Domain\Entities\Rank;
use Src\Recycling\Rank\Infraestructure\Models\RankModel;

trait UpdateRankTrait
{
    public function update(Rank $rank): void
    {
        $model = RankModel::find($rank->getIdValue());
        if ($model) {
            $model->update([
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
}
