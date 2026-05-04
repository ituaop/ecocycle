<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait DeleteUserTrait
{
    public function delete(UserId $id): void
    {
        $model = UserModel::find($id->value());

        if ($model) {
            $model->delete();
        }
    }
}
