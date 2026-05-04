<?php

namespace Src\Recycling\User\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * Nombre real del usuario (distinto de UserUserName que es el username/handle).
 */
class UserName
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (empty($value)) {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }

        if (strlen($value) < 2) {
            throw new InvalidArgumentException('El nombre debe tener al menos 2 caracteres.');
        }

        if (strlen($value) > 100) {
            throw new InvalidArgumentException('El nombre no puede superar los 100 caracteres.');
        }

        $this->value = $value;
    }

    public function value(): string { return $this->value; }
}
