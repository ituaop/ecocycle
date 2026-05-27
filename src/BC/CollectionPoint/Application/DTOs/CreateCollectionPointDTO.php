<?php

namespace Src\Recycling\CollectionPoint\Application\DTOs;

readonly class CreateCollectionPointDTO
{
    public function __construct(
        private ?string $id,
        private string  $name,
        private string  $address,
        private float   $latitude,
        private float   $longitude,
        private string  $status,
        private ?string $schedule           = null,
        private array   $acceptedCategories = []
    ) {}

    public function getId(): ?string      { return $this->id; }
    public function getName(): string     { return $this->name; }
    public function getAddress(): string  { return $this->address; }
    public function getLatitude(): float  { return $this->latitude; }
    public function getLongitude(): float { return $this->longitude; }
    public function getStatus(): string   { return $this->status; }
    public function getSchedule(): ?string { return $this->schedule; }
    public function getAcceptedCategories(): array { return $this->acceptedCategories; }
}
