<?php

namespace Src\Recycling\CollectionPoint\Application\Ports;

use Src\Recycling\CollectionPoint\Domain\Entities\CollectionPoint;
use Src\Recycling\CollectionPoint\Domain\ValueObjects\CollectionPointId;

interface CollectionPointRepositoryPort
{
    public function create(CollectionPoint $collectionPoint): void;
    public function read(CollectionPointId $id): ?CollectionPoint;
    public function update(CollectionPoint $collectionPoint): void;
    public function delete(CollectionPointId $id): void;
    public function getAllCollectionPoints(string $order = 'name', string $direction = 'asc', int $page = 1, int $perPage = 10): array;
    public function getActiveCollectionPoints(): array;
}