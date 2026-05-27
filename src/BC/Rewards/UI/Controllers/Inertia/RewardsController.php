<?php

namespace Src\Recycling\Rewards\UI\Controllers\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;


class RewardsController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user   = Auth::user();
        $userId = $user->id;
        $pts    = (int) ($user->total_points ?? 0);

        // All active rewards ordered
        $allRewards = DB::table('rewards')
            ->where('is_active', true)
            ->orderBy('points_required')
            ->orderBy('order')
            ->get();

        // Which rewards this user has already unlocked
        $unlockedIds = DB::table('user_rewards')
            ->where('user_id', $userId)
            ->pluck('reward_id')
            ->toArray();

        // Auto-unlock newly earned rewards (points >= required and not yet unlocked)
        $newlyUnlocked = [];
        foreach ($allRewards as $reward) {
            if ($pts >= $reward->points_required && !in_array($reward->id, $unlockedIds)) {
                DB::table('user_rewards')->insertOrIgnore([
                    'user_id'     => $userId,
                    'reward_id'   => $reward->id,
                    'unlocked_at' => now(),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
                $newlyUnlocked[] = $reward->id;
                $unlockedIds[]   = $reward->id;
            }
        }

        // Serialize rewards with unlock status
        $rewards = $allRewards->map(fn($r) => [
            'id'              => $r->id,
            'name'            => $r->name,
            'description'     => $r->description,
            'emoji'           => $r->emoji,
            'category'        => $r->category,
            'points_required' => (int) $r->points_required,
            'badge_color'     => $r->badge_color,
            'order'           => $r->order,
            'unlocked'        => in_array($r->id, $unlockedIds),
            'newly_unlocked'  => in_array($r->id, $newlyUnlocked),
        ])->toArray();

        // Stats
        $totalRewards    = count($rewards);
        $unlockedCount   = count($unlockedIds);
        $nextReward      = collect($rewards)->firstWhere('unlocked', false);
        $pointsToNext    = $nextReward ? max(0, $nextReward['points_required'] - $pts) : null;

        return Inertia::render('Rewards/Index', [
            'rewards'       => $rewards,
            'userPoints'    => $pts,
            'unlockedCount' => $unlockedCount,
            'totalRewards'  => $totalRewards,
            'nextReward'    => $nextReward,
            'pointsToNext'  => $pointsToNext,
        ]);
    }
}