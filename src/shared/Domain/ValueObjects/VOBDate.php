<?php

namespace Src\shared\Domain\ValueObjects;

use InvalidArgumentException;

abstract class VOBDate
{
    private string $value;

    public function __construct(string $value)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new InvalidArgumentException("El valor <{$value}> no es una fecha válida (formato: Y-m-d).");
        }
        $this->value = $value;
    }

    public function value(): string { return $this->value; }
    public function toDateTime(): \DateTime { return \DateTime::createFromFormat('Y-m-d', $this->value); }
    public function equals(self $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return $this->value; }
}
