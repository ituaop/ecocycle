<?php

namespace Src\Recycling\WasteItem\Application\UseCases;

use Exception;
use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;
use Src\Recycling\WasteItem\Domain\Entities\WasteItem;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;

class ReadWasteItemUseCase
{
    public function __construct(private WasteItemRepositoryPort $repository) {}

    public function execute(string $id): WasteItem
    {
        $item = $this->repository->read(new WasteItemId($id));

        if (!$item) {
            throw new Exception("WasteItem no encontrado.");
        }

        return $item;
    }
}
