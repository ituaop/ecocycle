<?php

namespace Src\Recycling\User\Application\Ports;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\Entities\UserWithPassword;

interface AuthUserRepositoryPort
{
    public function registerUser(User $user): void;
    public function findByEmailForAuth(string $email): ?UserWithPassword;
    public function emailExists(string $email): bool;
}
