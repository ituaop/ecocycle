<?php

namespace Src\Recycling\User\Infraestructure\Hydrators;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;
use Src\Recycling\User\Infraestructure\Models\UserModel;

class UserHydrator
{
    public static function toDomain(UserModel $model): User
    {
        return new User(
            new UserId($model->id),
            new UserUserName($model->username),
            new UserEmail($model->email),
            new UserPassword($model->password),
            new UserLevel($model->level),
            new UserTotalPoints((int) $model->total_points)
        );
    }
}
