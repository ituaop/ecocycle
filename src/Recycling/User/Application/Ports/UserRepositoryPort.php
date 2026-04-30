<?php

namespace Src\Recycling\User\Application\Ports;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserId;

/**
 * Puerto para operaciones CRUD generales del usuario.
 * NO incluye registro ni autenticación — eso es AuthUserRepositoryPort.
 */
interface UserRepositoryPort
{
    public function create(User $user): void;
    public function read(UserId $id): ?User;
    public function update(User $user): void;
    public function delete(UserId $id): void;
    public function getAllUsers(
        string $order     = 'name',
        string $direction = 'asc',
        int    $page      = 1,
        int    $perPage   = 10
    ): array;
    public function findByEmail(string $email): ?User;
}
