<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserId;

class ReadUserUseCase
{
    public function __construct(private UserRepositoryPort $repository) {}

    public function execute(string $id): User
    {
        $user = $this->repository->read(new UserId($id));

        if (!$user) {
            throw new Exception("Usuario no encontrado.");
        }

        return $user;
    }
}
