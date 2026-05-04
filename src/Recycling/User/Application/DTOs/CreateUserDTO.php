<?php

namespace Src\Recycling\User\Application\DTOs;

/**
 * DTO para crear/actualizar usuarios desde operaciones CRUD generales.
 * NO incluye contraseña — para eso usar RegisterUserDTO.
 */
readonly class CreateUserDTO
{
    public function __construct(
        private ?string $id,
        private string  $name,
        private string  $username,
        private string  $email,
        private string  $level,
        private int     $totalPoints
    ) {}

    public function getId(): ?string      { return $this->id; }
    public function getName(): string     { return $this->name; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string    { return $this->email; }
    public function getLevel(): string    { return $this->level; }
    public function getTotalPoints(): int { return $this->totalPoints; }
}
