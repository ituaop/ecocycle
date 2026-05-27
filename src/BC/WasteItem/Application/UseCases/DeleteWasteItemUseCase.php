<?php

namespace Src\Recycling\WasteItem\Application\UseCases;

use Exception;
use Src\Recycling\WasteItem\Application\Ports\WasteItemRepositoryPort;
use Src\Recycling\WasteItem\Domain\ValueObjects\WasteItemId;

class DeleteWasteItemUseCase
{
    public function __construct(private WasteItemRepositoryPort $repository) {}

    public function execute(string $id): void
    {
        $itemId = new WasteItemId($id);

        if (!$this->repository->read($itemId)) {
            throw new Exception("WasteItem no encontrado.");
        }

        $this->repository->delete($itemId);
    }
}
