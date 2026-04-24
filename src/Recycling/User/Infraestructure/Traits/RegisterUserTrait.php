<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait RegisterUserTrait
{
    public function registerUser(User $user): void
    {
        UserModel::create([
            'id'           => $user->getIdValue(),
            'name'         => $user->getNameValue(),
            'username'     => $user->getUsernameValue(),
            'email'        => $user->getEmailValue(),
            'password'     => $user->getPasswordHash(),
            'level'        => $user->getLevelValue(),
            'total_points' => $user->getTotalPointsValue(),
        ]);
    }
}
