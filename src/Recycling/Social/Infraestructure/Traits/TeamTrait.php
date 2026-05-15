<?php

namespace Src\Recycling\Social\Infraestructure\Traits;

use Illuminate\Support\Facades\DB;
use Src\Recycling\Social\Domain\Entities\Team;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Infraestructure\Hydrators\TeamHydrator;
use Src\Recycling\Social\Infraestructure\Models\TeamModel;

trait TeamTrait
{
    public function createTeam(Team $t): void
    {
        TeamModel::create([
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
        ]);
    }

    public function findTeamById(TeamId $id): ?Team
    {
        $m = TeamModel::find($id->value());
        return $m ? TeamHydrator::toDomain($m) : null;
    }

    public function findTeamBySlug(string $slug): ?Team
    {
        $m = TeamModel::where('slug', $slug)->first();
        return $m ? TeamHydrator::toDomain($m) : null;
    }

    public function getPublicTeams(int $limit = 20): array
    {
        return TeamModel::where('is_public', true)
            ->orderByDesc('total_points')
            ->limit($limit)
            ->get()
            ->map(fn($m) => TeamHydrator::toDomain($m))
            ->all();
    }

    public function getUserTeams(string $userId): array
    {
        return TeamModel::whereIn('id',
            DB::table('team_members')->where('user_id', $userId)->pluck('team_id')
        )
        ->orderByDesc('total_points')
        ->get()
        ->map(fn($m) => TeamHydrator::toDomain($m))
        ->all();
    }

    public function updateTeamPoints(TeamId $id, int $points): void
    {
        TeamModel::where('id', $id->value())->increment('total_points', $points);
    }

    public function deleteTeam(TeamId $id): void
    {
        TeamModel::find($id->value())?->delete();
    }
}

