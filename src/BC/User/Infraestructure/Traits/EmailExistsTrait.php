<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Infraestructure\Models\UserModel;

trait EmailExistsTrait
{

public function emailExists(string $email): bool
    {
        return UserModel::where('email', strtolower(trim($email)))->exists();
    }

}
