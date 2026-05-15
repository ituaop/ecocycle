<?php

namespace Src\Recycling\Social\Infraestructure\Hydrators;

use Src\Recycling\Social\Domain\Entities\Team;
use Src\Recycling\Social\Domain\ValueObjects\TeamId;
use Src\Recycling\Social\Domain\ValueObjects\TeamName;
use Src\Recycling\Social\Domain\ValueObjects\TeamOwnerId;
use Src\Recycling\Social\Domain\ValueObjects\TeamSlug;
use Src\Recycling\Social\Infraestructure\Models\TeamModel;

class TeamHydrator
{
    public static function toDomain(TeamModel $m): Team
    {
        return new Team(
            new TeamId($m->id),
            new TeamName($m->name),
            new TeamSlug($m->slug),
            $m->description,
            $m->emoji,
            $m->badge_color,
            new TeamOwnerId($m->owner_id),
            (bool) $m->is_public,
            (int) $m->max_members,
            (int) $m->total_points,
        );
    }
}
