<?php

namespace Src\Recycling\User\Domain\Entities;

use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;

/**
 * Entidad User extendida con contraseña.
 * SOLO se usa en flujos de autenticación (register / login).
 */
class UserWithPassword extends User
{
    private UserPassword $password;

    public function __construct(
        UserId          $id,
        UserName        $name,
        UserUserName    $username,
        UserEmail       $email,
        UserPassword    $password,
        UserLevel       $level,
        UserTotalPoints $totalPoints
    ) {
        parent::__construct($id, $name, $username, $email, $level, $totalPoints);
        $this->password = $password;
    }

    public function getPassword(): UserPassword { return $this->password; }
    public function getPasswordHash(): string   { return $this->password->value(); }

    public function verifyPassword(string $plain): bool
    {
        return $this->password->verify($plain);
    }
}
