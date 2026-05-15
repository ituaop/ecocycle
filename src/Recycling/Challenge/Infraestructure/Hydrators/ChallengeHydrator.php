<?php

namespace Src\Recycling\Challenge\Infraestructure\Hydrators;

use Carbon\Carbon;
use Src\Recycling\Challenge\Domain\Entities\Challenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeBadgeColor;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeBonusPoints;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeCategoryVO;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeEmoji;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeTargetValue;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeTitle;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeTypeVO;
use Src\Recycling\Challenge\Infraestructure\Models\ChallengeModel;

class ChallengeHydrator
{
    public static function toDomain(ChallengeModel $m): Challenge
    {
        return new Challenge(
            new ChallengeId($m->id),
            new ChallengeTitle($m->title),
            $m->description,
            new ChallengeEmoji($m->emoji),
            new ChallengeTypeVO($m->type),
            new ChallengeCategoryVO($m->category),
            new ChallengeTargetValue((int) $m->target_value),
            new ChallengeBonusPoints((int) $m->bonus_points),
            new ChallengeBadgeColor($m->badge_color),
            (bool) $m->is_active,
            Carbon::parse($m->starts_at),
            Carbon::parse($m->ends_at),
        );
    }
}

