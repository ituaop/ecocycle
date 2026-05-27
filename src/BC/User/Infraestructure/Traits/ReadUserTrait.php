<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Infraestructure\Hydrators\UserHydrator;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait ReadUserTrait
{
    public function read(UserId $id): ?User
    {
        $model = UserModel::find($id->value());

        return $model ? UserHydrator::toDomain($model) : null;
    }
}
