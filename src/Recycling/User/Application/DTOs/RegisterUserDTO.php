<?php

namespace Src\Recycling\User\Application\DTOs;

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
