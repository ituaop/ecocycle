<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

class RankMinPoints
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException(
                "Los puntos mínimos del rango no pueden ser negativos. Recibido: {$value}"
            );
        }
        $this->value = $value;
    }

    public function value(): int { return $this->value; }
    public function __toString(): string { return (string) $this->value; }
}


