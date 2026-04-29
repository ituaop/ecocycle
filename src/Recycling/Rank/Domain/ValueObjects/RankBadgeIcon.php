<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;

class RankBadgeIcon
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if (empty($value)) {
            throw new InvalidArgumentException('El icono del badge no puede estar vacío.');
        }
        $this->value = $value;
    }

    public function value(): string { return $this->value; }
    public function __toString(): string { return $this->value; }
}
