<?php

namespace Src\Recycling\Challenge\Infraestructure\Hydrators;

use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeCurrentValue;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;
use Src\Recycling\Challenge\Infraestructure\Models\UserChallengeModel;

class UserChallengeHydrator
{
    public static function toDomain(UserChallengeModel $m): UserChallenge
    {
        return new UserChallenge(
            new UserChallengeId($m->id),
            new UserChallengeUserId($m->user_id),
            new ChallengeId($m->challenge_id),
            new UserChallengeCurrentValue((int) $m->current_value),
            (bool) $m->completed,
            $m->completed_at,
            (bool) $m->reward_claimed,
        );
    }
}

