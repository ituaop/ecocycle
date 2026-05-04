<?php

namespace Src\Recycling\User\Domain\ValueObjects;

use InvalidArgumentException;

class UserPassword
{
    private string $hashedValue;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('La contraseña no puede estar vacía.');
        }
        $this->hashedValue = $value;
    }

    public static function fromPlainText(string $plain): self
    {
        if (strlen($plain) < 8) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 8 caracteres.');
        }
        return new self(password_hash($plain, PASSWORD_BCRYPT));
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function verify(string $plain): bool
    {
        return password_verify($plain, $this->hashedValue);
    }

    public function value(): string { return $this->hashedValue; }
    public function __toString(): string { return '***'; }
}
