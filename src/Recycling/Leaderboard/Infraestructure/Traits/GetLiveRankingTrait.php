<?php

namespace Src\Recycling\Leaderboard\Infraestructure\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait GetLiveRankingTrait
{
    public function getLiveRanking(string $period, int $limit = 50): array
    {
        $query = DB::table('recycling_users as u')
            ->select(
                'u.id',
                'u.name',
                'u.username',
                'u.level',
                DB::raw('ROW_NUMBER() OVER (ORDER BY score DESC) as position'),
                DB::raw('score'),
            );

        // Según el período, calculamos el score de forma distinta
        if ($period === 'ALLTIME') {
            $query = DB::table('recycling_users as u')
                ->select(
                    'u.id', 'u.name', 'u.username', 'u.level',
                    'u.total_points as score',
                    DB::raw('ROW_NUMBER() OVER (ORDER BY u.total_points DESC) as position'),
                )
                ->orderByDesc('u.total_points')
                ->limit($limit);
        } elseif ($period === 'WEEKLY') {
            $start = Carbon::now()->startOfWeek()->toDateString();
            $end   = Carbon::now()->endOfWeek()->toDateString();
            $query = DB::table('recycling_users as u')
                ->leftJoin('recycle_actions as ra', function ($j) use ($start, $end) {
                    $j->on('ra.user_id', '=', 'u.id')
                      ->whereBetween('ra.date', [$start, $end]);
                })
                ->select(
                    'u.id', 'u.name', 'u.username', 'u.level',
                    DB::raw('COALESCE(SUM(ra.points_earned), 0) as score'),
                    DB::raw('ROW_NUMBER() OVER (ORDER BY COALESCE(SUM(ra.points_earned),0) DESC) as position'),
                )
                ->groupBy('u.id', 'u.name', 'u.username', 'u.level')
                ->orderByDesc('score')
                ->limit($limit);
        } elseif ($period === 'MONTHLY') {
            $start = Carbon::now()->startOfMonth()->toDateString();
            $end   = Carbon::now()->endOfMonth()->toDateString();
            $query = DB::table('recycling_users as u')
                ->leftJoin('recycle_actions as ra', function ($j) use ($start, $end) {
                    $j->on('ra.user_id', '=', 'u.id')
                      ->whereBetween('ra.date', [$start, $end]);
                })
                ->select(
                    'u.id', 'u.name', 'u.username', 'u.level',
                    DB::raw('COALESCE(SUM(ra.points_earned), 0) as score'),
                    DB::raw('ROW_NUMBER() OVER (ORDER BY COALESCE(SUM(ra.points_earned),0) DESC) as position'),
                )
                ->groupBy('u.id', 'u.name', 'u.username', 'u.level')
                ->orderByDesc('score')
                ->limit($limit);
        }

        return $query->get()->map(fn($r) => [
            'id'       => $r->id,
            'name'     => $r->name,
            'username' => $r->username,
            'level'    => $r->level,
            'score'    => (int) $r->score,
            'position' => (int) $r->position,
        ])->toArray();
    }
}

