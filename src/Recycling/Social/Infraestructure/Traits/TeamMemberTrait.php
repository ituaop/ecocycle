<?php

namespace Src\Recycling\Social\Infraestructure\Traits;

use Src\Recycling\Social\Domain\Entities\TeamMember;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Infraestructure\Hydrators\TeamMemberHydrator;
use Src\Recycling\Social\Infraestructure\Models\TeamMemberModel;

trait TeamMemberTrait
{
    public function addMember(TeamMember $m): void
    {
        TeamMemberModel::create([
            'id'        => $m->getIdValue(),
            'team_id'   => $m->getTeamIdValue(),
            'user_id'   => $m->getUserId(),
            'role'      => $m->getRoleValue(),
            'joined_at' => $m->getJoinedAt(),
        ]);
    }

    public function removeMember(TeamId $teamId, string $userId): void
    {
        TeamMemberModel::where('team_id', $teamId->value())
            ->where('user_id', $userId)
            ->delete();
    }

    public function getTeamMembers(TeamId $teamId): array
    {
        return TeamMemberModel::where('team_id', $teamId->value())
            ->orderBy('joined_at')
            ->get()
            ->map(fn($m) => TeamMemberHydrator::toDomain($m))
            ->all();
    }

    public function findMembership(TeamId $teamId, string $userId): ?TeamMember
    {
        $m = TeamMemberModel::where('team_id', $teamId->value())
            ->where('user_id', $userId)
            ->first();
        return $m ? TeamMemberHydrator::toDomain($m) : null;
    }

    public function countMembers(TeamId $teamId): int
    {
        return TeamMemberModel::where('team_id', $teamId->value())->count();
    }
}

