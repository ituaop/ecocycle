<?php

namespace Src\Recycling\WasteItem\UI\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Src\Recycling\WasteItem\Application\UseCases\DeleteWasteItemUseCase;
use Src\Recycling\WasteItem\Application\UseCases\GetAllWasteItemsUseCase;

class WasteItemIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteWasteItem(string $id, DeleteWasteItemUseCase $useCase): void
    {
        try {
            $useCase->execute($id);
            session()->flash('message', 'WasteItem eliminado con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    public function render(GetAllWasteItemsUseCase $useCase)
    {
        $result = $useCase->execute();

        return view('livewire.recycling.waste-item.waste-item-index', [
            'wasteItems' => $result['items'],
        ])->layout('layouts.app');
    }
}
