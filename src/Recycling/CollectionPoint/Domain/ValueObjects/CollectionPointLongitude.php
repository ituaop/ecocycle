<?php

namespace Src\Recycling\CollectionPoint\Domain\ValueObjects;

use InvalidArgumentException;

class CollectionPointLongitude
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < -180 || $value > 180) {
            throw new InvalidArgumentException("La longitud <$value> no es válida. Debe estar entre -180 y 180.");
        }
        $this->value = $value;
    }

    public function value(): float { return $this->value; }
}
