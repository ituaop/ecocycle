<?php

namespace Src\Recycling\CollectionPoint\Domain\ValueObjects;

use InvalidArgumentException;

class CollectionPointLatitude
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < -90 || $value > 90) {
            throw new InvalidArgumentException("La latitud <$value> no es válida. Debe estar entre -90 y 90.");
        }
        $this->value = $value;
    }

    public function value(): float { return $this->value; }
}
