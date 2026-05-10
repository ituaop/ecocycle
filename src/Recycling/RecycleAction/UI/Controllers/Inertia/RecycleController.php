<?php
namespace Src\Recycling\RecycleAction\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\Rank\Application\Services\RankResolverService;

class RecycleController extends Controller
{
    public function __construct(private RankResolverService $rankResolver) {}

    public function index(): Response
    {
        $wasteItems = DB::table('waste_items')
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->map(fn($w) => [
                'id'          => $w->id,
                'name'        => $w->name,
                'description' => $w->description,
                'category'    => $w->category,
                'points'      => $w->points,
            ])
            ->groupBy('category')
            ->toArray();

        $collectionPoints = DB::table('collection_points')
            ->where('status', 'ACTIVE')
            ->orderBy('name')
            ->get()
            ->map(fn($cp) => [
                'id'                  => $cp->id,
                'name'                => $cp->name,
                'address'             => $cp->address,
                'latitude'            => (float) $cp->latitude,
                'longitude'           => (float) $cp->longitude,
                'schedule'            => $cp->schedule,
                'accepted_categories' => json_decode($cp->accepted_categories, true),
            ])
            ->toArray();

        return Inertia::render('Recycle/Index', [
            'wasteItemsByCategory' => $wasteItems,
            'collectionPoints'     => $collectionPoints,
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'waste_item_id'       => 'required|uuid|exists:waste_items,id',
            'collection_point_id' => 'required|uuid|exists:collection_points,id',
            'quantity'            => 'required|integer|min:1|max:999',
            'date'                => 'required|date|before_or_equal:today',
        ]);

        $user = Auth::user();

        // Obtener el waste item para calcular puntos
        $wasteItem = DB::table('waste_items')->find($request->waste_item_id);
        $pointsEarned = $wasteItem->points * (int) $request->quantity;

        $levelBefore = $user->level ?? 'BEGINNER';

        $newTotalPoints = ($user->total_points ?? 0) + $pointsEarned;

        $levelAfter = $this->rankResolver->resolveLevel($newTotalPoints);
        $levelUp    = $levelAfter !== $levelBefore;

        DB::table('recycle_actions')->insert([
            'id'                  => Str::uuid()->toString(),
            'user_id'             => $user->id,
            'waste_item_id'       => $request->waste_item_id,
            'collection_point_id' => $request->collection_point_id,
            'quantity'            => (int) $request->quantity,
            'date'                => $request->date,
            'points_earned'       => $pointsEarned,
            'level_before'        => $levelBefore,
            'level_after'         => $levelAfter,
            'level_up'            => $levelUp,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        DB::table('recycling_users')
            ->where('id', $user->id)
            ->update([
                'total_points' => $newTotalPoints,
                'level'        => $levelAfter,
                'updated_at'   => now(),
            ]);

        session()->flash('recycle_result', [
            'points_earned' => $pointsEarned,
            'total_points'  => $newTotalPoints,
            'level_before'  => $levelBefore,
            'level_after'   => $levelAfter,
            'level_up'      => $levelUp,
            'waste_name'    => $wasteItem->name,
            'quantity'      => (int) $request->quantity,
        ]);

        return redirect()->route('recycle.result');
    }


    public function result(): Response
    {
        $result = session('recycle_result');

        if (!$result) {
            return redirect()->route('recycle.index');
        }

        $user = Auth::user();

        $allRanks    = $this->rankResolver->getAllRanks();
        $nextRank    = $this->rankResolver->getNextRank($user->level);
        $progress    = $this->rankResolver->progressInCurrentRank($user->total_points, $user->level);
        $pointsToNext = $this->rankResolver->pointsToNextRank($user->total_points, $user->level);

        return Inertia::render('Recycle/Result', [
            'result'       => $result,
            'user'         => [
                'name'         => $user->name,
                'total_points' => $user->total_points,
                'level'        => $user->level,
            ],
            'allRanks'     => $allRanks,
            'nextRank'     => $nextRank,
            'progress'     => $progress,
            'pointsToNext' => $pointsToNext,
        ]);
    }
}
