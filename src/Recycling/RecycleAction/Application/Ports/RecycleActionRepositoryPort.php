<?php

namespace Src\Recycling\RecycleAction\Application\Ports;

use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;

interface RecycleActionRepositoryPort
{
    public function create(RecycleAction $action): void;
    public function read(RecycleActionId $id): ?RecycleAction;
    public function update(RecycleAction $action): void;
    public function delete(RecycleActionId $id): void;
    public function getAllRecycleActions(string $order = 'date', string $direction = 'desc', int $page = 1, int $perPage = 10): array;
    public function getAllByUserId(string $userId, string $order = 'date', string $direction = 'desc', int $page = 1, int $perPage = 10): array;
    public function getAllByCollectionPointId(string $collectionPointId, int $page = 1, int $perPage = 10): array;
}
