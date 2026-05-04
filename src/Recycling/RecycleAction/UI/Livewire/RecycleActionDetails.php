<?php

namespace Src\Recycling\RecycleAction\UI\Livewire;

use Livewire\Component;
use Src\Recycling\RecycleAction\Application\UseCases\ReadRecycleActionUseCase;

class RecycleActionDetails extends Component
{
    public string $actionId = '';

    public function mount(string $id): void
    {
        $this->actionId = $id;
    }

    public function render(ReadRecycleActionUseCase $useCase)
    {
        $action = $useCase->execute($this->actionId);

        return view('livewire.recycling.recycle-action.recycle-action-details', [
            'action' => $action,
        ])->layout('layouts.app');
    }
}
