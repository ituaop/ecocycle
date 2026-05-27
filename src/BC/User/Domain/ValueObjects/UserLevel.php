<?php

namespace Src\Recycling\User\Domain\ValueObjects;

use InvalidArgumentException;
use Src\Recycling\User\Domain\Enumerations\UserLevelEnumeration;

class UserLevel
{
    private UserLevelEnumeration $value;

    public function __construct(string $level)
    {
        $enum = UserLevelEnumeration::tryFrom(strtoupper($level));

        if (!$enum) {
            throw new InvalidArgumentException("El nivel <$level> no es válido para un Usuario.");
        }

        $this->value = $enum;
    }

    public function value(): string { return $this->value->value; }
    public function getEnum(): UserLevelEnumeration { return $this->value; }

    public function isBeginner(): bool     { return $this->value === UserLevelEnumeration::BEGINNER; }
    public function isIntermediate(): bool { return $this->value === UserLevelEnumeration::INTERMEDIATE; }
    public function isAdvanced(): bool     { return $this->value === UserLevelEnumeration::ADVANCED; }
    public function isExpert(): bool       { return $this->value === UserLevelEnumeration::EXPERT; }

    public function equals(UserLevel $other): bool { return $this->value === $other->value; }
}
