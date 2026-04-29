<?php

namespace Src\Recycling\CollectionPoint\Domain\ValueObjects;

/**
 * Horario del punto de recogida. Puede ser null (sin horario definido).
 */
class CollectionPointSchedule
{
    private ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value !== null ? trim($value) : null;
        if ($this->value === '') {
            $this->value = null;
        }
    }

    public function value(): ?string { return $this->value; }
    public function hasSchedule(): bool { return $this->value !== null; }
    public function __toString(): string { return $this->value ?? ''; }
}
