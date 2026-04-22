<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Infraestructure\Hydrators\UserHydrator;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait FindUserByEmailTrait
{
    public function findByEmail(string $email): ?User
    {
        $model = UserModel::where('email', $email)->first();

        return $model ? UserHydrator::toDomain($model) : null;
    }
}