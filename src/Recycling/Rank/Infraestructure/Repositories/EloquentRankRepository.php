<?php

namespace Src\Recycling\Rank\Infraestructure\Repositories;

use Src\Recycling\Rank\Application\Ports\RankRepositoryPort;
use Src\Recycling\Rank\Infraestructure\Traits\CreateRankTrait;
use Src\Recycling\Rank\Infraestructure\Traits\DeleteRankTrait;
use Src\Recycling\Rank\Infraestructure\Traits\FindRankByNameTrait;
use Src\Recycling\Rank\Infraestructure\Traits\GetAllRanksTrait;
use Src\Recycling\Rank\Infraestructure\Traits\ReadRankTrait;
use Src\Recycling\Rank\Infraestructure\Traits\ResolveRankByPointsTrait;
use Src\Recycling\Rank\Infraestructure\Traits\UpdateRankTrait;

class EloquentRankRepository implements RankRepositoryPort
{
    use CreateRankTrait,
        ReadRankTrait,
        UpdateRankTrait,
        DeleteRankTrait,
        GetAllRanksTrait,
        FindRankByNameTrait,
        ResolveRankByPointsTrait;
}
