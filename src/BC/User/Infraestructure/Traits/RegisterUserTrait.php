<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\Entities\UserWithPassword;
use Src\Recycling\User\Infraestructure\Models\UserAuthModel;

trait RegisterUserTrait
{
    public function registerUser(User $user): void
    {
        /** @var UserWithPassword $user */
        UserAuthModel::create([
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
