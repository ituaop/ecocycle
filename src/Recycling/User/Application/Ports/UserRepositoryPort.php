<?php

namespace Src\Recycling\User\Application\Ports;

use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserId;

interface UserRepositoryPort
{
    public function registerUser(User $user): void;
    public function read(UserId $id): ?User;
    public function update(User $user): void;
    public function delete(UserId $id): void;
    public function getAllUsers(string $order = 'username', string $direction = 'asc', int $page = 1, int $perPage = 10): array;
    public function findByEmail(string $email): ?User;
    public function emailExists(string $email): bool;
}
