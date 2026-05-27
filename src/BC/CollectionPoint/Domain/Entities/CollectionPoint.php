<?php

namespace Src\Recycling\CollectionPoint\Domain\Entities;

use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAcceptedCategories;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAddress;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLatitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLongitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointName;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointSchedule;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointStatus;

class CollectionPoint
{
    private CollectionPointId                 $id;
    private CollectionPointName               $name;
    private CollectionPointAddress            $address;
    private CollectionPointLatitude           $latitude;
    private CollectionPointLongitude          $longitude;
    private CollectionPointStatus             $status;
    private CollectionPointSchedule           $schedule;
    private CollectionPointAcceptedCategories $acceptedCategories;

    public function __construct(
        CollectionPointId                 $id,
        CollectionPointName               $name,
        CollectionPointAddress            $address,
        CollectionPointLatitude           $latitude,
        CollectionPointLongitude          $longitude,
        CollectionPointStatus             $status,
        CollectionPointSchedule           $schedule,
        CollectionPointAcceptedCategories $acceptedCategories
    ) {
        $this->id                 = $id;
        $this->name               = $name;
        $this->address            = $address;
        $this->latitude           = $latitude;
        $this->longitude          = $longitude;
        $this->status             = $status;
        $this->schedule           = $schedule;
        $this->acceptedCategories = $acceptedCategories;
    }

    public function getId(): CollectionPointId                     { return $this->id; }
    public function getIdValue(): string                           { return $this->id->value(); }

    public function getName(): CollectionPointName                 { return $this->name; }
    public function getNameValue(): string                         { return $this->name->value(); }

    public function getAddress(): CollectionPointAddress           { return $this->address; }
    public function getAddressValue(): string                      { return $this->address->value(); }

    public function getLatitude(): CollectionPointLatitude         { return $this->latitude; }
    public function getLatitudeValue(): float                      { return $this->latitude->value(); }

    public function getLongitude(): CollectionPointLongitude       { return $this->longitude; }
    public function getLongitudeValue(): float                     { return $this->longitude->value(); }

    public function getStatus(): CollectionPointStatus             { return $this->status; }
    public function getStatusValue(): string                       { return $this->status->value(); }

    public function getSchedule(): CollectionPointSchedule         { return $this->schedule; }
    public function getScheduleValue(): ?string                    { return $this->schedule->value(); }

    public function getAcceptedCategories(): CollectionPointAcceptedCategories { return $this->acceptedCategories; }
    public function getAcceptedCategoriesValue(): array            { return $this->acceptedCategories->value(); }
    public function getAcceptedCategoriesJson(): string            { return $this->acceptedCategories->toJson(); }

    public function acceptsCategory(string $category): bool
    {
        return $this->acceptedCategories->accepts($category);
    }
}
