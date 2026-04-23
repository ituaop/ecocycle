<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Src\Recycling\User\Application\DTOs\CreateUserDTO;
use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;

class UpdateUserUseCase
{
    public function __construct(private UserRepositoryPort $repository) {}

    public function execute(CreateUserDTO $dto): User
    {
        $id = new UserId($dto->getId());

        if (!$this->repository->read($id)) {
            throw new Exception("No se puede actualizar: el usuario no existe.");
        }

        $user = new User(
            $id,
            new UserUserName($dto->getUsername()),
            new UserEmail($dto->getEmail()),
            new UserPassword($dto->getPassword()),
            new UserLevel($dto->getLevel()),
            new UserTotalPoints($dto->getTotalPoints())
        );

        $this->repository->update($user);

        return $user;
    }
}
