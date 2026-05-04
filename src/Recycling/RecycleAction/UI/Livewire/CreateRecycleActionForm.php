<?php

namespace Src\Recycling\RecycleAction\UI\Livewire;

use Livewire\Component;
use Src\Recycling\RecycleAction\Application\DTOs\CreateRecycleActionDTO;
use Src\Recycling\RecycleAction\Application\UseCases\CreateRecycleActionUseCase;

class CreateRecycleActionForm extends Component
{
    public ?string $id                = null;
    public string  $userId            = '';
    public string  $wasteItemId       = '';
    public string  $collectionPointId = '';
    public int     $quantity          = 1;
    public string  $date              = '';
    public int     $pointsEarned      = 0;

    public function mount(string $userId): void
    {
        $this->userId = $userId;
        $this->date   = now()->format('Y-m-d');
    }

    public function submit(CreateRecycleActionUseCase $useCase)
    {
        $this->validate([
            'wasteItemId'       => 'required|uuid',
            'collectionPointId' => 'required|uuid',
            'quantity'          => 'required|integer|min:1',
            'date'              => 'required|date',
        ]);

        try {
            $dto = new CreateRecycleActionDTO(
                id:                $this->id,
                userId:            $this->userId,
                wasteItemId:       $this->wasteItemId,
                collectionPointId: $this->collectionPointId,
                quantity:          $this->quantity,
                date:              $this->date,
                pointsEarned:      $this->pointsEarned
            );

            $useCase->execute($dto);

            session()->flash('success', '¡Acción de reciclaje registrada con éxito!');
            return redirect()->route('recycling.actions.index');
        } catch (\Exception $e) {
            $this->addError('action_creation', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.recycling.recycle-action.create-recycle-action-form')->layout('layouts.app');
    }
}
