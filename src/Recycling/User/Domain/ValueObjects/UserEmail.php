<?php

namespace Src\Recycling\User\Domain\ValueObjects;

use InvalidArgumentException;

class UserEmail
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidEmail($value);
        $this->value = strtolower(trim($value));
    }

    private function ensureIsValidEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El email <$value> no es válido.");
        }
    }

    public function value(): string { return $this->value; }
}
