<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;

abstract class VOBInteger
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException("El valor entero no puede ser negativo en " . static::class);
        }
        $this->value = $value;
    }

    public function value(): int { return $this->value; }
    public function equals(self $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return (string) $this->value; }
}
