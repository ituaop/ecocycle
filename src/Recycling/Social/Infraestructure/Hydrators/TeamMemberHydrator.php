<?php

namespace Src\Recycling\Social\Infraestructure\Hydrators;

use Src\Recycling\Social\Domain\Entities\TeamMember;
use Src\Recycling\Social\Domain\Enumerations\TeamMemberRole;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Domain\ValueObjects\TeamMemberId;
use Src\Recycling\Social\Infraestructure\Models\TeamMemberModel;

class TeamMemberHydrator
{
    public static function toDomain(TeamMemberModel $m): TeamMember
    {
        return new TeamMember(
            new TeamMemberId($m->id),
            new TeamId($m->team_id),
            $m->user_id,
            TeamMemberRole::from($m->role),
            $m->joined_at,
        );
    }
}

