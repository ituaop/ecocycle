<?php

namespace Src\Recycling\RecycleAction\UI\Livewire;

use Livewire\Component;
use Src\Recycling\RecycleAction\Application\DTOs\CreateRecycleActionDTO;
use Src\Recycling\RecycleAction\Application\UseCases\ReadRecycleActionUseCase;
use Src\Recycling\RecycleAction\Application\UseCases\UpdateRecycleActionUseCase;

class EditRecycleActionForm extends Component
{
    public string $actionId          = '';
    public string $userId            = '';
    public string $wasteItemId       = '';
    public string $collectionPointId = '';
    public int    $quantity          = 1;
    public string $date              = '';
    public int    $pointsEarned      = 0;

    public function mount(string $id, ReadRecycleActionUseCase $useCase): void
    {
        $action = $useCase->execute($id);

        $this->actionId          = $action->getIdValue();
        $this->userId            = $action->getUserIdValue();
        $this->wasteItemId       = $action->getWasteItemIdValue();
        $this->collectionPointId = $action->getCollectionPointIdValue();
        $this->quantity          = $action->getQuantityValue();
        $this->date              = $action->getDateValue();
        $this->pointsEarned      = $action->getPointsEarnedValue();
    }

    public function update(UpdateRecycleActionUseCase $useCase)
    {
        $this->validate([
            'wasteItemId'       => 'required|uuid',
            'collectionPointId' => 'required|uuid',
            'quantity'          => 'required|integer|min:1',
            'date'              => 'required|date',
        ]);

        $dto = new CreateRecycleActionDTO(
            id:                $this->actionId,
            userId:            $this->userId,
            wasteItemId:       $this->wasteItemId,
            collectionPointId: $this->collectionPointId,
            quantity:          $this->quantity,
            date:              $this->date,
            pointsEarned:      $this->pointsEarned
        );

        $useCase->execute($dto);

        session()->flash('message', 'Acción de reciclaje actualizada correctamente.');
        return redirect()->route('recycling.actions.index');
    }

    public function render()
    {
        return view('livewire.recycling.recycle-action.edit-recycle-action-form')->layout('layouts.app');
    }
}
