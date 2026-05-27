<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait UpdateUserTrait
{
    public function update(User $user): void
    {
        $model = UserModel::find($user->getIdValue());

        if ($model) {
            $model->update([
                'name'         => $user->getNameValue(),
                'username'     => $user->getUsernameValue(),
                'email'        => $user->getEmailValue(),
                'level'        => $user->getLevelValue(),
                'total_points' => $user->getTotalPointsValue(),
            ]);
        }
    }
}
