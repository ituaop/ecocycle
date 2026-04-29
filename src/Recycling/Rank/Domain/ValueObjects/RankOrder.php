<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

class RankOrder
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new InvalidArgumentException(
                "El orden del rango debe ser >= 1. Recibido: {$value}"
            );
        }
        $this->value = $value;
    }

    public function value(): int { return $this->value; }
    public function __toString(): string { return (string) $this->value; }
}