<?php

namespace Src\Recycling\WasteItem\Application\Ports;

use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;

interface WasteItemRepositoryPort
{
    public function create(WasteItem $wasteItem): void;
    public function read(WasteItemId $id): ?WasteItem;
    public function update(WasteItem $wasteItem): void;
    public function delete(WasteItemId $id): void;
    public function getAllWasteItems(string $order = 'name', string $direction = 'asc', int $page = 1, int $perPage = 10): array;
    public function getByCategory(string $category): array;
}
