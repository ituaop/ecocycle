<?php

namespace Src\Recycling\CollectionPoint\Domain\Entities;

use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointAddress;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLatitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointLongitude;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointName;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointStatus;

class CollectionPoint
{
    private CollectionPointId        $id;
    private CollectionPointName      $name;
    private CollectionPointAddress   $address;
    private CollectionPointLatitude  $latitude;
    private CollectionPointLongitude $longitude;
    private CollectionPointStatus    $status;

    public function __construct(
        CollectionPointId        $id,
        CollectionPointName      $name,
        CollectionPointAddress   $address,
        CollectionPointLatitude  $latitude,
        CollectionPointLongitude $longitude,
        CollectionPointStatus    $status
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->address   = $address;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->status    = $status;
    }

    public function getId(): CollectionPointId                 { return $this->id; }
    public function getIdValue(): string                       { return $this->id->value(); }

    public function getName(): CollectionPointName             { return $this->name; }
    public function getNameValue(): string                     { return $this->name->value(); }

    public function getAddress(): CollectionPointAddress       { return $this->address; }
    public function getAddressValue(): string                  { return $this->address->value(); }

    public function getLatitude(): CollectionPointLatitude     { return $this->latitude; }
    public function getLatitudeValue(): float                  { return $this->latitude->value(); }

    public function getLongitude(): CollectionPointLongitude   { return $this->longitude; }
    public function getLongitudeValue(): float                 { return $this->longitude->value(); }

    public function getStatus(): CollectionPointStatus         { return $this->status; }
    public function getStatusValue(): string                   { return $this->status->value(); }
}
