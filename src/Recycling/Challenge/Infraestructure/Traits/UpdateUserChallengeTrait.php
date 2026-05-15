<?php

namespace Src\Recycling\Challenge\Infraestructure\Traits;

use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Infraestructure\Models\UserChallengeModel;

trait UpdateUserChallengeTrait
{
    public function updateUserChallenge(UserChallenge $uc): void
    {
        $m = UserChallengeModel::find($uc->getIdValue());
        if ($m) {
            $m->update([
                'current_value'  => $uc->getCurrentValueInt(),
                'completed'      => $uc->isCompleted(),
                'completed_at'   => $uc->getCompletedAt(),
                'reward_claimed' => $uc->isRewardClaimed(),
            ]);
        }
    }
}


