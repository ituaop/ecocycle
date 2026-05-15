<?php

namespace Src\Recycling\Challenge\Infraestructure\Traits;

use Src\Recycling\Challenge\Domain\Entities\UserChallenge;
use Src\Recycling\Challenge\Infraestructure\Models\UserChallengeModel;

trait CreateUserChallengeTrait
{
    public function createUserChallenge(UserChallenge $uc): void
    {
        UserChallengeModel::create([
            'id'            => $uc->getIdValue(),
            'user_id'       => $uc->getUserIdValue(),
            'challenge_id'  => $uc->getChallengeIdValue(),
            'current_value' => $uc->getCurrentValueInt(),
            'completed'     => $uc->isCompleted(),
            'completed_at'  => $uc->getCompletedAt(),
            'reward_claimed'=> $uc->isRewardClaimed(),
        ]);
    }
}
