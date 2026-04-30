<?php

namespace Src\Recycling\User\Infraestructure\Hydrators;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;
use Src\Recycling\User\Infraestructure\Models\UserModel;

class UserHydrator
{
    /**
     * Convierte un UserModel a entidad de dominio User (sin contraseña).
     * Para rehidratar con contraseña usa EloquentAuthUserRepository.
     */
    public static function toDomain(UserModel $model): User
    {
        return new User(
            new UserId($model->id),
            new UserName($model->name),
            new UserUserName($model->username),
            new UserEmail($model->email),
            new UserLevel($model->level),
            new UserTotalPoints((int) $model->total_points)
        );
    }

    /**
     * Serializa una entidad User a array para Eloquent.
     * NO incluye contraseña — usar EloquentAuthUserRepository para eso.
     */
    public static function toDatabase(User $user): array
    {
        return [
            'id'           => $user->getIdValue(),
            'name'         => $user->getNameValue(),
            'username'     => $user->getUsernameValue(),
            'email'        => $user->getEmailValue(),
            'level'        => $user->getLevelValue(),
            'total_points' => $user->getTotalPointsValue(),
        ];
    }
}
