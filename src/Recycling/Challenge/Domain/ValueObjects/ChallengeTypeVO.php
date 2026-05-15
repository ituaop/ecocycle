<?php

namespace Src\Recycling\Challenge\Domain\ValueObjects;

use Src\Recycling\Challenge\Domain\Enumerations\ChallengeType;

class ChallengeTypeVO
{
    private ChallengeType $type;

    public function __construct(string $type)
    {
        $this->type = ChallengeType::from($type);
    }

    public function value(): string         { return $this->type->value; }
    public function label(): string         { return $this->type->label(); }
    public function emoji(): string         { return $this->type->emoji(); }
    public function enum(): ChallengeType   { return $this->type; }
}

