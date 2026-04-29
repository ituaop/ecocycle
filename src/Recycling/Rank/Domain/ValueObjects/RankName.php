<?php

namespace Src\Recycling\Rank\Domain\ValueObjects;

use InvalidArgumentException;
use Src\Recycling\Rank\Domain\Enumerations\RankNameEnumeration;

class RankName
{
    private RankNameEnumeration $value;

    public function __construct(string $name)
    {
        $enum = RankNameEnumeration::tryFrom(strtoupper($name));

        if (!$enum) {
            $valid = implode(', ', array_column(RankNameEnumeration::cases(), 'value'));
            throw new InvalidArgumentException(
                "El nombre de rango <{$name}> no es válido. Valores permitidos: {$valid}"
            );
        }

        $this->value = $enum;
    }

    public function value(): string { return $this->value->value; }
    public function getEnum(): RankNameEnumeration { return $this->value; }
    public function equals(self $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return $this->value->value; }
}
