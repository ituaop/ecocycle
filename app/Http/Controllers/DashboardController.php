<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\Rank\Application\Services\RankResolverService;

class DashboardController extends Controller
{
    public function __construct(private RankResolverService $rankResolver) {}

    public function __invoke(Request $request): Response
    {
        $user   = Auth::user();
        $userId = $user->id;

        // Últimas 8 acciones con join a waste_items y collection_points
        $recentActions = DB::table('recycle_actions as ra')
            ->join('waste_items as wi',        'ra.waste_item_id',       '=', 'wi.id')
            ->join('collection_points as cp',  'ra.collection_point_id', '=', 'cp.id')
            ->where('ra.user_id', $userId)
            ->orderByDesc('ra.date')
            ->orderByDesc('ra.created_at')
            ->limit(8)
            ->select([
                'ra.id', 'ra.quantity', 'ra.date', 'ra.points_earned',
                'ra.level_up', 'ra.level_before', 'ra.level_after',
                'wi.name as waste_name', 'wi.category as waste_category',
                'cp.name as cp_name',
            ])
            ->get()
            ->map(fn($r) => (array) $r)
            ->toArray();

        // Totales
        $totals = DB::table('recycle_actions')
            ->where('user_id', $userId)
            ->selectRaw('COUNT(*) as total_actions, SUM(points_earned) as total_pts, SUM(quantity) as total_units')
            ->first();

        // Puntos por categoría
        $byCategory = DB::table('recycle_actions as ra')
            ->join('waste_items as wi', 'ra.waste_item_id', '=', 'wi.id')
            ->where('ra.user_id', $userId)
            ->groupBy('wi.category')
            ->selectRaw('wi.category, COUNT(*) as actions, SUM(ra.points_earned) as points, SUM(ra.quantity) as units')
            ->orderByDesc('points')
            ->get()
            ->map(fn($r) => (array) $r)
            ->toArray();

        // Actividad de los últimos 7 días
        $weekActivity = DB::table('recycle_actions')
            ->where('user_id', $userId)
            ->where('date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('date')
            ->selectRaw('date, SUM(points_earned) as points, COUNT(*) as actions')
            ->orderBy('date')
            ->get()
            ->map(fn($r) => (array) $r)
            ->toArray();

        // Info del rango actual
        $allRanks     = $this->rankResolver->getAllRanks();
        $nextRank     = $this->rankResolver->getNextRank($user->level ?? 'BEGINNER');
        $progress     = $this->rankResolver->progressInCurrentRank($user->total_points ?? 0, $user->level ?? 'BEGINNER');
        $pointsToNext = $this->rankResolver->pointsToNextRank($user->total_points ?? 0, $user->level ?? 'BEGINNER');

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'total_actions' => (int) ($totals->total_actions ?? 0),
                'total_points'  => (int) ($totals->total_pts ?? 0),
                'total_units'   => (int) ($totals->total_units ?? 0),
                'level'         => $user->level ?? 'BEGINNER',
            ],
            'recentActions' => $recentActions,
            'byCategory'    => $byCategory,
            'weekActivity'  => $weekActivity,
            'rankInfo' => [
                'allRanks'     => $allRanks,
                'nextRank'     => $nextRank,
                'progress'     => $progress,
                'pointsToNext' => $pointsToNext,
            ],
        ]);
    }
}
