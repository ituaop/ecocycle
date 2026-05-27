<?php

namespace Src\Recycling\User\Application\DTOs;


readonly class LoginUserDTO
{
    public function __construct(
        private string $email,
        private string $plainPassword,
        private bool   $remember = false
    ) {}

    public function getEmail(): string        { return $this->email; }
    public function getPlainPassword(): string { return $this->plainPassword; }
    public function getRemember(): bool       { return $this->remember; }
}
