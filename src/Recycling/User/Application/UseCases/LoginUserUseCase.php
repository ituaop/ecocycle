<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Src\Recycling\User\Application\DTOs\LoginUserDTO;
use Src\Recycling\User\Application\Ports\AuthUserRepositoryPort;
use Src\Recycling\User\Domain\Entities\UserWithPassword;

class LoginUserUseCase
{
    public function __construct(private AuthUserRepositoryPort $repository) {}

    public function execute(LoginUserDTO $dto): UserWithPassword
    {
        $user = $this->repository->findByEmailForAuth($dto->getEmail());

        if (!$user instanceof UserWithPassword) {
            throw new Exception('Las credenciales no son correctas.');
        }

        if (!$user->verifyPassword($dto->getPlainPassword())) {
            throw new Exception('Las credenciales no son correctas.');
        }

        return $user;
    }
}
