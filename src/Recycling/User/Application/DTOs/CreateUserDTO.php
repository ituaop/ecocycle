<?php

namespace Src\Recycling\User\Application\DTOs;

readonly class CreateUserDTO
{
    public function __construct(
        private ?string $id,
        private string  $username,
        private string $name,
        private string  $email,
        private string $password,
        private string  $level,
        private int     $totalPoints
    ) {}

    public function getId(): ?string    { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getName(): string        { return $this->name; }
    public function getEmail(): string  { return $this->email; }
    public function getPassword(): string  { return $this->password; }
    public function getLevel(): string  { return $this->level; }
    public function getTotalPoints(): int { return $this->totalPoints; }
}
