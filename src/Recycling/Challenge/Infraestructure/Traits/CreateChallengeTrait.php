<?php

namespace Src\Recycling\Challenge\Infraestructure\Traits;

use Src\Recycling\Challenge\Domain\Entities\Challenge;
use Src\Recycling\Challenge\Infraestructure\Models\ChallengeModel;

trait CreateChallengeTrait
{
    public function create(Challenge $c): void
    {
        ChallengeModel::create([
            'id'           => $c->getIdValue(),
            'title'        => $c->getTitleValue(),
            'description'  => $c->getDescription(),
            'emoji'        => $c->getEmojiValue(),
            'type'         => $c->getTypeValue(),
            'category'     => $c->getCategoryValue(),
            'target_value' => $c->getTargetValueInt(),
            'bonus_points' => $c->getBonusPointsInt(),
            'badge_color'  => $c->getBadgeColorValue(),
            'is_active'    => $c->isActive(),
            'starts_at'    => $c->getStartsAt()->toDateString(),
            'ends_at'      => $c->getEndsAt()->toDateString(),
        ]);
    }
}
