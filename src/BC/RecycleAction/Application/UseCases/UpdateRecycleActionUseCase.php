<?php

namespace Src\Recycling\RecycleAction\Application\UseCases;

use Exception;
use Src\Recycling\RecycleAction\Application\DTOs\CreateRecycleActionDTO;
use Src\Recycling\RecycleAction\Application\Ports\RecycleActionRepositoryPort;
use Src\Recycling\RecycleAction\Domain\Entities\RecycleAction;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionCollectionPointId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionDate;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionPointsEarned;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionQuantity;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionUserId;
use Src\Recycling\RecycleAction\Domain\ValueObjects\RecycleActionWasteItemId;

class UpdateRecycleActionUseCase
{
    public function __construct(private RecycleActionRepositoryPort $repository) {}

    public function execute(CreateRecycleActionDTO $dto): RecycleAction
    {
        $id = new RecycleActionId($dto->getId());

        if (!$this->repository->read($id)) {
            throw new Exception("No se puede actualizar: la RecycleAction no existe.");
        }

        $action = new RecycleAction(
            $id,
            new RecycleActionUserId($dto->getUserId()),
            new RecycleActionWasteItemId($dto->getWasteItemId()),
            new RecycleActionCollectionPointId($dto->getCollectionPointId()),
            new RecycleActionQuantity($dto->getQuantity()),
            new RecycleActionDate($dto->getDate()),
            new RecycleActionPointsEarned($dto->getPointsEarned())
        );

        $this->repository->update($action);

        return $action;
    }
}
