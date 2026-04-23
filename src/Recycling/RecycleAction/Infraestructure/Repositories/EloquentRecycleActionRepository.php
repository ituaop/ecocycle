<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Repositories;

use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;
use Src\Recycling\RecycleAction\Infraestructure\Traits\CreateRecycleActionTrait;
use Src\Recycling\RecycleAction\Infraestructure\Traits\DeleteRecycleActionTrait;
use Src\Recycling\RecycleAction\Infraestructure\Traits\GetAllRecycleActionsTrait;
use Src\Recycling\RecycleAction\Infraestructure\Traits\ReadRecycleActionTrait;
use Src\Recycling\RecycleAction\Infraestructure\Traits\UpdateRecycleActionTrait;

class EloquentRecycleActionRepository implements RecycleActionRepositoryPort
{
    use CreateRecycleActionTrait,
        ReadRecycleActionTrait,
        UpdateRecycleActionTrait,
        DeleteRecycleActionTrait,
        GetAllRecycleActionsTrait;
}
