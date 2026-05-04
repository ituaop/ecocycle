<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * Puntos máximos del rango.
 * El valor 0 significa "sin límite superior" (rango máximo del sistema).
 */
class RankMaxPoints
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException(
                "Los puntos máximos no pueden ser negativos. Usa 0 para indicar sin límite. Recibido: {$value}"
            );
        }
        $this->value = $value;
    }

    public function value(): int { return $this->value; }

    /** Devuelve true si este rango es el máximo (sin límite superior). */
    public function isUnlimited(): bool { return $this->value === 0; }

    public function __toString(): string { return (string) $this->value; }
}