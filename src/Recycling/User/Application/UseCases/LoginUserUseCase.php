<?php

namespace Src\Recycling\User\Application\UseCases;

use Exception;
use Src\Recycling\User\Application\DTOs\LoginUserDTO;
use Src\Recycling\User\Application\Ports\AuthUserRepositoryPort;
use Src\Recycling\User\Domain\Entities\UserWithPassword;

/**
 * Caso de uso: Inicio de sesión (Log In).
 *
 * Responsabilidades:
 *  1. Buscar el usuario por email.
 *  2. Verificar que la contraseña en texto plano coincide con el hash.
 *  3. Devolver la entidad si las credenciales son correctas.
 *  4. Lanzar excepción genérica si falla (sin revelar si el email existe).
 */
class LoginUserUseCase
{
    public function __construct(private AuthUserRepositoryPort $repository) {}

    public function execute(LoginUserDTO $dto): UserWithPassword
    {
        // 1. Buscar usuario — mensaje genérico para no revelar si el email existe
        $user = $this->repository->findByEmailForAuth($dto->getEmail());

        if (!$user instanceof UserWithPassword) {
            throw new Exception('Las credenciales no son correctas.');
        }

        // 2. Verificar contraseña usando el VO
        if (!$user->verifyPassword($dto->getPlainPassword())) {
            throw new Exception('Las credenciales no son correctas.');
        }

        return $user;
    }
}
