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
        $id       = new UserId($uuid);
        $name     = new UserName($dto->getName());
        $username = new UserUserName(
            strtolower(str_replace(' ', '_', $dto->getName())) . '_' . substr($uuid, 0, 6)
        );
        $email    = new UserEmail($dto->getEmail());
        $password = UserPassword::fromPlainText($dto->getPlainPassword());
        $level    = new UserLevel('BEGINNER');
        $points   = new UserTotalPoints(0);

        $user = new UserWithPassword($id, $name, $username, $email, $password, $level, $points);
        $this->repository->registerUser($user);

        return $user;
    }
}
