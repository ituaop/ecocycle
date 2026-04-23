<?php

namespace Src\Recycling\RecycleAction\UI\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Src\Recycling\RecycleAction\Application\UseCases\DeleteRecycleActionUseCase;
use Src\Recycling\RecycleAction\Application\UseCases\GetAllRecycleActionsUseCase;

class RecycleActionIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteRecycleAction(string $id, DeleteRecycleActionUseCase $useCase): void
    {
        try {
            $useCase->execute($id);
            session()->flash('message', 'RecycleAction eliminada con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    public function render(GetAllRecycleActionsUseCase $useCase)
    {
        $result = $useCase->execute();

        return view('livewire.recycling.recycle-action.recycle-action-index', [
            'actions' => $result['items'],
        ])->layout('layouts.app');
    }
}
