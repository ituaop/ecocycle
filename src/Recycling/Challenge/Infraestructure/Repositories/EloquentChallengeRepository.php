<?php

namespace Src\Recycling\Challenge\Infraestructure\Repositories;

use Src\Recycling\Challenge\Application\Ports\ChallengeRepositoryPort;
use Src\Recycling\Challenge\Infraestructure\Traits\CreateChallengeTrait;
use Src\Recycling\Challenge\Infraestructure\Traits\CreateUserChallengeTrait;
use Src\Recycling\Challenge\Infraestructure\Traits\FindUserChallengeTrait;
use Src\Recycling\Challenge\Infraestructure\Traits\GetActiveChallengesTrait;
use Src\Recycling\Challenge\Infraestructure\Traits\ReadChallengeTrait;
use Src\Recycling\Challenge\Infraestructure\Traits\UpdateUserChallengeTrait;

class EloquentChallengeRepository implements ChallengeRepositoryPort
{
    use CreateChallengeTrait,
        ReadChallengeTrait,
        GetActiveChallengesTrait,
        CreateUserChallengeTrait,
        UpdateUserChallengeTrait,
        FindUserChallengeTrait;
}
