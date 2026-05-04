<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;

abstract class VOBUuid
{
    private string $value;

    public function __construct(?string $value)
    {
        if ($value === null) {
            $value = \Illuminate\Support\Str::uuid()->toString();
        }

        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value)) {
            throw new InvalidArgumentException("El valor <{$value}> no es un UUID válido.");
        }

        $this->value = strtolower($value);
    }

    public function value(): string { return $this->value; }
    public function equals(self $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return $this->value; }
}
