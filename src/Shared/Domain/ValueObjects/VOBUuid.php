<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * Value Object base para UUIDs.
 * Valida el formato UUID v4 y lo normaliza en minúsculas.
 */
abstract class VOBUuid
{
    private string $value;

    public function __construct(?string $value)
    {
        // Si viene null generamos uno nuevo
        if ($value === null) {
            $value = \Illuminate\Support\Str::uuid()->toString();
        }

        $this->ensureIsValidUuid($value);
        $this->value = strtolower($value);
    }

    private function ensureIsValidUuid(string $value): void
    {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        if (!preg_match($pattern, $value)) {
            throw new InvalidArgumentException(
                "El valor <{$value}> no es un UUID válido."
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
