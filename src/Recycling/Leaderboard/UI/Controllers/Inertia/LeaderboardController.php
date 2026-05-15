<?php

namespace Src\Recycling\Leaderboard\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\Leaderboard\Application\UseCases\GetLiveLeaderboardUseCase;
use Src\Recycling\Leaderboard\Application\UseCases\GetUserLeaderboardHistoryUseCase;
use Src\Recycling\Leaderboard\Application\UseCases\GetUserLeaderboardPositionUseCase;
use Src\Recycling\Leaderboard\Domain\Enumerations\LeaderboardPeriod;

class LeaderboardController extends Controller
{
    public function __construct(
        private GetLiveLeaderboardUseCase        $getLiveLeaderboard,
        private GetUserLeaderboardPositionUseCase $getUserPosition,
        private GetUserLeaderboardHistoryUseCase  $getUserHistory,
    ) {}

    public function __invoke(Request $request): Response
    {
        $periodParam = strtoupper($request->input('period', 'WEEKLY'));
        $period      = LeaderboardPeriod::tryFrom($periodParam)?->value ?? LeaderboardPeriod::WEEKLY->value;

        $userId    = Auth::id();
        $user      = Auth::user();

        $ranking      = $this->getLiveLeaderboard->execute($period, 50);
        $userPosition = $this->getUserPosition->execute($userId, $period);
        $userHistory  = $this->getUserHistory->execute($userId, $period);

        // Encontrar al usuario actual dentro del ranking
        $userInRanking = collect($ranking)->firstWhere('id', $userId);

        // Top 3 separado para podio
        $podium  = array_slice($ranking, 0, 3);
        $restRanking = array_slice($ranking, 3);

        return Inertia::render('Leaderboard/Index', [
            'ranking'       => $ranking,
            'podium'        => $podium,
            'restRanking'   => $restRanking,
            'userPosition'  => $userPosition,
            'userInRanking' => $userInRanking,
            'userHistory'   => collect($userHistory)->map(fn($e) => [
                'period_key' => $e->getPeriodKey(),
                'points'     => $e->getPointsInt(),
                'position'   => $e->getPositionInt(),
            ])->toArray(),
            'currentPeriod' => $period,
            'periods'       => collect(LeaderboardPeriod::cases())->map(fn($p) => [
                'value' => $p->value,
                'label' => $p->label(),
                'emoji' => $p->emoji(),
            ])->toArray(),
            'currentUser'   => [
                'id'    => $userId,
                'name'  => $user->name,
                'level' => $user->level,
                'total_points' => $user->total_points,
            ],
        ]);
    }
}