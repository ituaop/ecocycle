<?php

namespace Src\Recycling\Social\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\Social\Application\UseCases\GetGlobalFeedUseCase;
use Src\Recycling\Social\Application\UseCases\GetPublicTeamsUseCase;
use Src\Recycling\Social\Application\UseCases\GetUserTeamsUseCase;
use Src\Recycling\Social\Domain\Entities\Team;
use Src\Recycling\Social\Domain\Entities\FeedEntry;
use Illuminate\Support\Facades\DB;

class SocialController extends Controller
{
    public function __construct(
        private GetUserTeamsUseCase   $getUserTeams,
        private GetPublicTeamsUseCase $getPublicTeams,
        private GetGlobalFeedUseCase  $getGlobalFeed,
    ) {}

    public function __invoke(): Response
    {
        $userId     = Auth::id();
        $userTeams  = $this->getUserTeams->execute($userId);
        $publicTeams= $this->getPublicTeams->execute(20);
        $feed       = $this->getGlobalFeed->execute($userId, 30);

        // Enriquecer equipos con conteo de miembros
        $enrichTeam = function (Team $t) use ($userId) {
            $memberCount = DB::table('team_members')->where('team_id', $t->getIdValue())->count();
            $isMember    = DB::table('team_members')->where('team_id', $t->getIdValue())->where('user_id', $userId)->exists();
            return [
                'id'           => $t->getIdValue(),
                'name'         => $t->getNameValue(),
                'slug'         => $t->getSlugValue(),
                'description'  => $t->getDescription(),
                'emoji'        => $t->getEmoji(),
                'badge_color'  => $t->getBadgeColor(),
                'owner_id'     => $t->getOwnerIdValue(),
                'is_public'    => $t->isPublic(),
                'max_members'  => $t->getMaxMembers(),
                'total_points' => $t->getTotalPoints(),
                'member_count' => $memberCount,
                'is_member'    => $isMember,
                'is_owner'     => $t->getOwnerIdValue() === $userId,
            ];
        };

        $userIds   = collect($feed)
    ->pluck('userId')
    ->filter() 
    ->map(fn($u) => $u->value()) 
    ->unique()
    ->toArray();
        $users     = DB::table('recycling_users')->whereIn('id', $userIds)->get()->keyBy('id');

        $serialFeed = collect($feed)->map(function (FeedEntry $e) use ($users) {
            $u = $users->get($e->getUserIdValue());
            return [
                'id'          => $e->getIdValue(),
                'user_id'     => $e->getUserIdValue(),
                'user_name'   => $u?->name ?? 'Usuario',
                'user_level'  => $u?->level ?? 'BEGINNER',
                'team_id'     => $e->getTeamId(),
                'type'        => $e->getTypeValue(),
                'title'       => $e->getTitle(),
                'description' => $e->getDescription(),
                'emoji'       => $e->getEmoji(),
                'points'      => $e->getPoints(),
                'meta'        => $e->getMeta(),
                'created_at'  => $e->getCreatedAt()->diffForHumans(),
            ];
        })->toArray();

        return Inertia::render('Social/Index', [
            'myTeams'     => collect($userTeams)->map($enrichTeam)->values()->toArray(),
            'publicTeams' => collect($publicTeams)->map($enrichTeam)->values()->toArray(),
            'feed'        => $serialFeed,
        ]);
    }
}
