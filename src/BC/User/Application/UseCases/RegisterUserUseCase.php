<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Illuminate\Support\Str;
use Src\Recycling\User\Application\DTOs\RegisterUserDTO;
use Src\Recycling\User\Application\Ports\AuthUserRepositoryPort;
use Src\Recycling\User\Domain\Entities\UserWithPassword;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;

class RegisterUserUseCase
{
    public function __construct(private AuthUserRepositoryPort $repository) {}

    public function execute(RegisterUserDTO $dto): UserWithPassword
    {
        if ($dto->getPlainPassword() !== $dto->getPasswordConfirmation()) {
            throw new Exception('Las contraseñas no coinciden.');
        }

        if ($this->repository->emailExists($dto->getEmail())) {
            throw new Exception('Ya existe una cuenta con ese correo electrónico.');
        }

        $uuid     = Str::uuid()->toString();
        $username = strtolower(str_replace(' ', '_', $dto->getName()))
                  . '_' . substr($uuid, 0, 6);

        $user = new UserWithPassword(
            new UserId($uuid),
            new UserName($dto->getName()),
            new UserUserName($username),
            new UserEmail($dto->getEmail()),
            UserPassword::fromPlainText($dto->getPlainPassword()),
            new UserLevel('BEGINNER'),
            new UserTotalPoints(0)
        );

        $this->repository->registerUser($user);

        return $user;
    }
}
