<?php
namespace Src\Recycling\User\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\Rank\Application\Services\RankResolverService;

class ProfileController extends Controller
{
    public function __construct(private RankResolverService $rankResolver) {}

    public function show(): Response
    {
        $user   = Auth::user();
        $userId = $user->id;

        // Historial completo con joins
        $history = DB::table('recycle_actions as ra')
            ->join('waste_items as wi',       'ra.waste_item_id',       '=', 'wi.id')
            ->join('collection_points as cp', 'ra.collection_point_id', '=', 'cp.id')
            ->where('ra.user_id', $userId)
            ->orderByDesc('ra.date')
            ->orderByDesc('ra.created_at')
            ->select([
                'ra.id', 'ra.quantity', 'ra.date', 'ra.points_earned',
                'ra.level_up', 'ra.level_before', 'ra.level_after',
                'wi.name as waste_name', 'wi.category as waste_category',
                'cp.name as cp_name', 'cp.address as cp_address',
            ])
            ->paginate(15);

        $totals = DB::table('recycle_actions')
            ->where('user_id', $userId)
            ->selectRaw('COUNT(*) as total_actions, SUM(points_earned) as total_pts, SUM(quantity) as total_units, COUNT(DISTINCT waste_item_id) as unique_materials')
            ->first();

        $allRanks     = $this->rankResolver->getAllRanks();
        $nextRank     = $this->rankResolver->getNextRank($user->level ?? 'BEGINNER');
        $progress     = $this->rankResolver->progressInCurrentRank($user->total_points ?? 0, $user->level ?? 'BEGINNER');
        $pointsToNext = $this->rankResolver->pointsToNextRank($user->total_points ?? 0, $user->level ?? 'BEGINNER');

        return Inertia::render('Profile/Show', [
            'profileUser' => [
                'id'           => $user->id,
                'name'         => $user->name,
                'username'     => $user->username,
                'email'        => $user->email,
                'level'        => $user->level ?? 'BEGINNER',
                'total_points' => (int) ($user->total_points ?? 0),
                'member_since' => $user->created_at,
            ],
            'stats' => [
                'total_actions'    => (int) ($totals->total_actions ?? 0),
                'total_points'     => (int) ($totals->total_pts ?? 0),
                'total_units'      => (int) ($totals->total_units ?? 0),
                'unique_materials' => (int) ($totals->unique_materials ?? 0),
            ],
            'history'     => $history->items(),
            'pagination'  => [
                'total'       => $history->total(),
                'currentPage' => $history->currentPage(),
                'lastPage'    => $history->lastPage(),
                'perPage'     => $history->perPage(),
            ],
            'rankInfo' => [
                'allRanks'     => $allRanks,
                'nextRank'     => $nextRank,
                'progress'     => $progress,
                'pointsToNext' => $pointsToNext,
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:recycling_users,email,' . Auth::id(),
        ]);

        DB::table('recycling_users')->where('id', Auth::id())->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'updated_at' => now(),
        ]);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        DB::table('recycling_users')->where('id', $user->id)->update([
            'password'   => Hash::make($request->password),
            'updated_at' => now(),
        ]);

        return back()->with('status', 'password-updated');
    }
}
