<?php

namespace Src\Recycling\Challenge\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Recycling\Challenge\Application\UseCases\ClaimChallengeRewardUseCase;

class ClaimRewardController extends Controller
{
    public function __construct(private ClaimChallengeRewardUseCase $claimReward) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate(['user_challenge_id' => 'required|uuid']);

        $bonus = $this->claimReward->execute(Auth::id(), $request->user_challenge_id);

        return back()->with('success', "¡Has reclamado {$bonus} puntos bonus!");
    }

}
