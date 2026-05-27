<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

class RankId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("El ID del rango debe ser un entero positivo. Recibido: {$value}");
        }
        $this->value = $value;
    }

    public function value(): int { return $this->value; }
    public function equals(self $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return (string) $this->value; }
}


