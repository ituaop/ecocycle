<?php

namespace Src\Recycling\Challenge\Domain\ValueObjects;

use Src\Recycling\Challenge\Domain\Enumerations\ChallengeCategory;

class ChallengeCategoryVO
{
    private ChallengeCategory $category;

    public function __construct(string $category)
    {
        $this->category = ChallengeCategory::from($category);
    }

    public function value(): string               { return $this->category->value; }
    public function label(): string               { return $this->category->label(); }
    public function description(int $t): string   { return $this->category->description($t); }
    public function enum(): ChallengeCategory     { return $this->category; }
}

