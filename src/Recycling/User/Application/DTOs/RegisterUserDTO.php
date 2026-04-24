<?php

namespace Src\Recycling\User\Application\DTOs;

/**
 * DTO para el caso de uso de registro de usuario (Create Account).
 * Lleva la contraseña en texto plano; el UseCase se encarga de hashearla.
 */
readonly class RegisterUserDTO
{
    public function __construct(
        private string $name,
        private string $email,
        private string $plainPassword,
        private string $passwordConfirmation
    ) {}

    public function getName(): string                { return $this->name; }
    public function getEmail(): string               { return $this->email; }
    public function getPlainPassword(): string       { return $this->plainPassword; }
    public function getPasswordConfirmation(): string { return $this->passwordConfirmation; }
}
