<?php

namespace Src\Recycling\WasteItem\Application\DTOs;

readonly class CreateWasteItemDTO
{
    public function __construct(
        private ?string $id,
        private string  $name,
        private string  $description,
        private string  $category,
        private int     $points
    ) {}

    public function getId(): ?string        { return $this->id; }
    public function getName(): string       { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getCategory(): string   { return $this->category; }
    public function getPoints(): int        { return $this->points; }
}
