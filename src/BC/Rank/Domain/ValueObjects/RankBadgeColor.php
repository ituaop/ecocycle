<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

class RankBadgeColor
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if (!preg_match('/^#[0-9a-fA-F]{3,6}$/', $value)) {
            throw new InvalidArgumentException(
                "El color de badge <{$value}> no es un color hexadecimal válido (ej: #2d6a4f)."
            );
        }
        $this->value = strtolower($value);
    }

    public function value(): string { return $this->value; }
    public function __toString(): string { return $this->value; }
}