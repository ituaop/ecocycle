<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait CreateUserTrait
{
    public function create(User $user): void
    {
        UserModel::create([
            'id'           => $user->getIdValue(),
            'name'         => $user->getNameValue(),
            'username'     => $user->getUsernameValue(),
            'email'        => $user->getEmailValue(),
            'level'        => $user->getLevelValue(),
            'total_points' => $user->getTotalPointsValue(),
        ]);
    }
}
