<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Domain\ValueObjects\UserId;

class DeleteUserUseCase
{
    public function __construct(private UserRepositoryPort $repository) {}

    public function execute(string $id): void
    {
        $userId = new UserId($id);

        if (!$this->repository->read($userId)) {
            throw new Exception("Usuario no encontrado.");
        }

        $this->repository->delete($userId);
    }
}