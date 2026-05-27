<?php

namespace Src\Recycling\WasteItem\Domain\ValueObjects;

use InvalidArgumentException;
use Src\Recycling\WasteItem\Domain\Enumerations\WasteItemCategoryEnumeration;

class WasteItemCategory
{
    private WasteItemCategoryEnumeration $value;

    public function __construct(string $category)
    {
        $enum = WasteItemCategoryEnumeration::tryFrom(strtoupper($category));

        if (!$enum) {
            throw new InvalidArgumentException("La categoría <$category> no es válida para un WasteItem.");
        }

        $this->value = $enum;
    }

    public function value(): string { return $this->value->value; }
    public function getEnum(): WasteItemCategoryEnumeration { return $this->value; }
}
