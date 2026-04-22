<?php

namespace Src\Recycling\CollectionPoint\Domain\ValueObjects;

use InvalidArgumentException;
use Src\Recycling\CollectionPoint\Domain\Enumerations\CollectionPointStatusEnumeration;

class CollectionPointStatus
{
    private CollectionPointStatusEnumeration $value;

    public function __construct(string $status)
    {
        $enum = CollectionPointStatusEnumeration::tryFrom(strtoupper($status));

        if (!$enum) {
            throw new InvalidArgumentException("El estado <$status> no es válido para un Punto de Recogida.");
        }

        $this->value = $enum;
    }

    public function value(): string { return $this->value->value; }
    public function getEnum(): CollectionPointStatusEnumeration { return $this->value; }

    public function isActive(): bool   { return $this->value === CollectionPointStatusEnumeration::ACTIVE; }
    public function isInactive(): bool { return $this->value === CollectionPointStatusEnumeration::INACTIVE; }
    public function isFull(): bool     { return $this->value === CollectionPointStatusEnumeration::FULL; }
}