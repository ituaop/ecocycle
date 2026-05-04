<?php

namespace Src\Recycling\CollectionPoint\Domain\ValueObjects;

class CollectionPointSchedule
{
    private ?string $value;

    public function __construct(?string $value)
    {
        $trimmed = $value !== null ? trim($value) : null;
        $this->value = ($trimmed === '' || $trimmed === null) ? null : $trimmed;
    }

    public function value(): ?string   { return $this->value; }
    public function hasSchedule(): bool { return $this->value !== null; }
    public function __toString(): string { return $this->value ?? ''; }
}
