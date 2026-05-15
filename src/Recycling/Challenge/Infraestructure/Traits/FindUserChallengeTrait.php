<?php

namespace Src\Recycling\Challenge\Infraestructure\Traits;

use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Domain\ValueObjects\ChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeId;
use Src\Recycling\Challenge\Domain\ValueObjects\UserChallengeUserId;
use Src\Recycling\Challenge\Infraestructure\Hydrators\UserChallengeHydrator;
use Src\Recycling\Challenge\Infraestructure\Models\UserChallengeModel;

trait FindUserChallengeTrait
{
    public function findUserChallenge(UserChallengeUserId $userId, ChallengeId $challengeId): ?UserChallenge
    {
        $m = UserChallengeModel::where('user_id', $userId->value())
            ->where('challenge_id', $challengeId->value())
            ->first();
        return $m ? UserChallengeHydrator::toDomain($m) : null;
    }

    public function getUserChallenges(UserChallengeUserId $userId): array
    {
        return UserChallengeModel::where('user_id', $userId->value())
            ->get()
            ->map(fn($m) => UserChallengeHydrator::toDomain($m))
            ->all();
    }

    public function readUserChallenge(UserChallengeId $id): ?UserChallenge
    {
        $m = UserChallengeModel::find($id->value());
        return $m ? UserChallengeHydrator::toDomain($m) : null;
    }
}