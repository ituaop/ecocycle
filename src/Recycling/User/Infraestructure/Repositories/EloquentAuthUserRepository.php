<?php

namespace Src\Recycling\User\Infraestructure\Repositories;

use Src\Recycling\User\Application\Ports\AuthUserRepositoryPort;
use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\Entities\UserWithPassword;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;
use Src\Recycling\User\Infraestructure\Models\UserAuthModel;

class EloquentAuthUserRepository implements AuthUserRepositoryPort
{
    /**
     * Persiste un nuevo usuario con su contraseña hasheada.
     */
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

    /**
     * Busca por email y devuelve UserWithPassword (con hash) para autenticación.
     */
    public function findByEmailForAuth(string $email): ?UserWithPassword
    {
        $model = UserAuthModel::where('email', strtolower(trim($email)))->first();

        if (!$model) {
            return null;
        }

        return new UserWithPassword(
            new UserId($model->id),
            new UserName($model->name),
            new UserUserName($model->username),
            new UserEmail($model->email),
            UserPassword::fromHash($model->password),
            new UserLevel($model->level),
            new UserTotalPoints((int) $model->total_points)
        );
    }

    /**
     * Comprueba si ya existe un email registrado.
     */
    public function emailExists(string $email): bool
    {
        return UserAuthModel::where('email', strtolower(trim($email)))->exists();
    }
}
