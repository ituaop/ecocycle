<?php

namespace Src\Recycling\Social\Infraestructure\Repositories;

use Src\Recycling\Social\Application\Ports\SocialRepositoryPort;
use Src\Recycling\Social\Infraestructure\Traits\FeedTrait;
use Src\Recycling\Social\Infraestructure\Traits\TeamMemberTrait;
use Src\Recycling\Social\Infraestructure\Traits\TeamTrait;

class EloquentSocialRepository implements SocialRepositoryPort
{
    use TeamTrait,
        TeamMemberTrait,
        FeedTrait;
}