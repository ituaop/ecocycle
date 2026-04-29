<?php

namespace Src\Recycling\User\Infraestructure\Hydrators;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
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
            new UserName($model->name),
            new UserEmail($model->email),
            new UserPassword($model->password),
            new UserLevel($model->level),
            new UserTotalPoints((int) $model->total_points)
        );
    }
    public static function toDatabase(User $user):array{
        return [
            'id'=>$user->getIdValue(),
            'name'=>$user->getNameValue(),
            'username'=>$user->getUsernameValue(),
            'email'=>$user->getEmailValue(),
            'password'=>$user->getPasswordHash(),
            'level'=>$user->getLevelValue(),
            'total_points'=>$user->getTotalPointsValue()
        ];
    }
}
