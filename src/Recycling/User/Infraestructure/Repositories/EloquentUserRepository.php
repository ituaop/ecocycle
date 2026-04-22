<?php

namespace Src\Recycling\User\Infraestructure\Repositories;

use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Infraestructure\Traits\CreateUserTrait;
use Src\Recycling\User\Infraestructure\Traits\DeleteUserTrait;
use Src\Recycling\User\Infraestructure\Traits\FindUserByEmailTrait;
use Src\Recycling\User\Infraestructure\Traits\GetAllUsersTrait;
use Src\Recycling\User\Infraestructure\Traits\ReadUserTrait;
use Src\Recycling\User\Infraestructure\Traits\UpdateUserTrait;

class EloquentUserRepository implements UserRepositoryPort
{
    use CreateUserTrait,
        ReadUserTrait,
        UpdateUserTrait,
        DeleteUserTrait,
        GetAllUsersTrait,
        FindUserByEmailTrait;
}