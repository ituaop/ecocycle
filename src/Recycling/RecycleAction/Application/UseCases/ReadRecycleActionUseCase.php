<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Exception;
use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;
use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;

class ReadRecycleActionUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(string $id): RecycleAction
    {
        $action = $this->repository->read(new RecycleActionId($id));

        if (!$action) {
            throw new Exception("RecycleAction no encontrada.");
        }

        return $action;
    }
}
