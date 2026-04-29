<?php

namespace Src\Recycling\User\Application\UseCases;

use Src\Recycling\User\Application\DTOs\CreateUserDTO;
use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Domain\Entities\User;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;

class CreateUserUseCase
{
    public function __construct(private UserRepositoryPort $repository) {}

    public function execute(CreateUserDTO $dto): User
    {
     
        $user = new User(
            new UserId($dto->getId()),
            new UserUserName($dto->getUsername()),
            new UserName($dto->getName()),
            new UserEmail($dto->getEmail()),
            new UserPassword($dto->getPassword()),
            new UserLevel($dto->getLevel()),
            new UserTotalPoints($dto->getTotalPoints())
        );

        $this->repository->registerUser($user);

        return $user;
    }
}
