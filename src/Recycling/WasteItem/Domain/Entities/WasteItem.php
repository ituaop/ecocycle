<?php

namespace Src\Recycling\WasteItem\Domain\Entities;

use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemCategory;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemDescription;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemName;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemPoints;

class WasteItem
{
    private WasteItemId          $id;
    private WasteItemName        $name;
    private WasteItemDescription $description;
    private WasteItemCategory    $category;
    private WasteItemPoints      $points;

    public function __construct(
        WasteItemId          $id,
        WasteItemName        $name,
        WasteItemDescription $description,
        WasteItemCategory    $category,
        WasteItemPoints      $points
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->description = $description;
        $this->category    = $category;
        $this->points      = $points;
    }

    public function getId(): WasteItemId               { return $this->id; }
    public function getIdValue(): string               { return $this->id->value(); }

    public function getName(): WasteItemName           { return $this->name; }
    public function getNameValue(): string             { return $this->name->value(); }

    public function getDescription(): WasteItemDescription { return $this->description; }
    public function getDescriptionValue(): string          { return $this->description->value(); }

    public function getCategory(): WasteItemCategory   { return $this->category; }
    public function getCategoryValue(): string         { return $this->category->value(); }

    public function getPoints(): WasteItemPoints       { return $this->points; }
    public function getPointsValue(): int              { return $this->points->value(); }
}
