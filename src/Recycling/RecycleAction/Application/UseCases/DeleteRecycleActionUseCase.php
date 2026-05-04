<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Exception;
use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;

class DeleteRecycleActionUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(string $id): void
    {
        $actionId = new RecycleActionId($id);

        if (!$this->repository->read($actionId)) {
            throw new Exception("RecycleAction no encontrada.");
        }

        $this->repository->delete($actionId);
    }
}
