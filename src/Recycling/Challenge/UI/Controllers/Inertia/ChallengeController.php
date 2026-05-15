<?php

namespace Src\Recycling\Challenge\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\Challenge\Application\UseCases\GetActiveChallengesUseCase;
use Src\Recycling\Challenge\Application\UseCases\GetUserChallengesUseCase;
use Src\Recycling\Challenge\Domain\Entities\Challenge;
use Src\Recycling\Challenge\Domain\Entities\UserChallenge;

class ChallengeController extends Controller
{
    public function __construct(
        private GetActiveChallengesUseCase $getActive,
        private GetUserChallengesUseCase   $getUserChallenges,
    ) {}

    public function __invoke(): Response
    {
        $userId         = Auth::id();
        $challenges     = $this->getActive->execute();
        $userChallenges = $this->getUserChallenges->execute($userId);

        // Indexar userChallenges por challenge_id para lookup rápido
        $ucByChallenge = collect($userChallenges)->keyBy(
            fn(UserChallenge $uc) => $uc->getChallengeIdValue()
        );

        $serialized = collect($challenges)->map(function (Challenge $c) use ($ucByChallenge) {
            $uc      = $ucByChallenge->get($c->getIdValue());
            $current = $uc?->getCurrentValueInt() ?? 0;
            $target  = $c->getTargetValueInt();

            return [
                'id'              => $c->getIdValue(),
                'title'           => $c->getTitleValue(),
                'description'     => $c->getDescription(),
                'emoji'           => $c->getEmojiValue(),
                'type'            => $c->getTypeValue(),
                'type_label'      => $c->getType()->label(),
                'type_emoji'      => $c->getType()->emoji(),
                'category'        => $c->getCategoryValue(),
                'category_label'  => $c->getCategory()->label(),
                'target_value'    => $target,
                'bonus_points'    => $c->getBonusPointsInt(),
                'badge_color'     => $c->getBadgeColorValue(),
                'starts_at'       => $c->getStartsAt()->toDateString(),
                'ends_at'         => $c->getEndsAt()->toDateString(),
                'days_remaining'  => $c->daysRemaining(),
                // progreso del usuario
                'joined'          => $uc !== null,
                'user_challenge_id' => $uc?->getIdValue(),
                'current_value'   => $current,
                'completed'       => $uc?->isCompleted() ?? false,
                'reward_claimed'  => $uc?->isRewardClaimed() ?? false,
                'progress_pct'    => $uc ? $uc->progressPercent($target) : 0,
            ];
        })->values()->toArray();

        $joined    = collect($serialized)->where('joined', true)->count();
        $completed = collect($serialized)->where('completed', true)->count();

        return Inertia::render('Challenges/Index', [
            'challenges'        => $serialized,
            'joinedCount'       => $joined,
            'completedCount'    => $completed,
            'totalChallenges'   => count($serialized),
        ]);
    }
}