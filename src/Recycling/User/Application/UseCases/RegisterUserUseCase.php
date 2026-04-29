<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Illuminate\Support\Str;
use Src\Recycling\User\Application\DTOs\RegisterUserDTO;
use Src\Recycling\User\Application\Ports\UserRepositoryPort;
use Src\Recycling\User\Domain\Entities\UserWithPassword;
use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserPassword;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;

/**
 * Caso de uso: Registro de un nuevo usuario (Create Account).
 *
 * Responsabilidades:
 *  1. Validar que las contraseñas coincidan.
 *  2. Validar que el email no esté ya registrado.
 *  3. Hashear la contraseña mediante el VO UserPassword.
 *  4. Generar un UUID para el nuevo usuario.
 *  5. Asignar nivel inicial BEGINNER y 0 puntos.
 *  6. Persistir a través del puerto.
 *  7. Devolver la entidad creada (sin contraseña expuesta).
 */
class RegisterUserUseCase
{
    public function __construct(private AuthUserRepositoryPort $repository) {}

    public function execute(RegisterUserDTO $dto): UserWithPassword
    {
        // 1. Las contraseñas deben coincidir
        if ($dto->getPlainPassword() !== $dto->getPasswordConfirmation()) {
            throw new Exception('Las contraseñas no coinciden.');
        }

        // 2. El email no debe estar ya registrado
        if ($this->repository->emailExists($dto->getEmail())) {
            throw new Exception('Ya existe una cuenta con ese correo electrónico.');
        }

        // 3. Construir Value Objects — el VO hashea la contraseña internamente
        $id       = new UserId(Str::uuid()->toString());
        $name     = new UserName($dto->getName());
        // El username se genera a partir del nombre (sin espacios, lowercase)
        $username = new UserUserName(
            strtolower(str_replace(' ', '_', $dto->getName())) . '_' . substr($id->value(), 0, 6)
        );
        $email    = new UserEmail($dto->getEmail());
        $password = UserPassword::fromPlainText($dto->getPlainPassword());
        $level    = new UserLevel('BEGINNER');
        $points   = new UserTotalPoints(0);

        // 4. Crear la entidad
        $user = new UserWithPassword($id, $name, $username, $email, $password, $level, $points);

        // 5. Persistir
        $this->repository->registerUser($user);

        return $user;
    }
}
