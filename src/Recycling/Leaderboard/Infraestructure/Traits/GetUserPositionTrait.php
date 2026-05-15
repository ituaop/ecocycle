<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Src\Recycling\Leaderboard\Domain\ValueObjects\LeaderboardUserId;

trait GetUserPositionTrait
{
    public function getUserPosition(LeaderboardUserId $userId, string $period): int
    {
        // Cuenta cuántos usuarios tienen mayor score que el usuario actual
        if ($period === 'ALLTIME') {
            $userScore = DB::table('recycling_users')
                ->where('id', $userId->value())
                ->value('total_points') ?? 0;

            $above = DB::table('recycling_users')
                ->where('total_points', '>', $userScore)
                ->count();
        } else {
            [$start, $end] = $period === 'WEEKLY'
                ? [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]
                : [Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()];

            $userScore = DB::table('recycle_actions')
                ->where('user_id', $userId->value())
                ->whereBetween('date', [$start, $end])
                ->sum('points_earned');

            $above = DB::table('recycle_actions')
                ->whereBetween('date', [$start, $end])
                ->groupBy('user_id')
                ->havingRaw('SUM(points_earned) > ?', [$userScore])
                ->distinct()
                ->count('user_id');
        }

        return $above + 1;
    }
}