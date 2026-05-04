<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;

abstract class VOBString
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if (empty($value)) {
            throw new InvalidArgumentException('El valor string no puede estar vacío en ' . static::class);
        }
        $this->value = $value;
    }

    public function value(): string { return $this->value; }
    public function equals(self $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return $this->value; }
}
