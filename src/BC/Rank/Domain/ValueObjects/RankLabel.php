<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

class RankLabel
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if (empty($value)) {
            throw new InvalidArgumentException('La etiqueta del rango no puede estar vacía.');
        }
        $this->value = $value;
    }

    public function value(): string { return $this->value; }
    public function __toString(): string { return $this->value; }
}
