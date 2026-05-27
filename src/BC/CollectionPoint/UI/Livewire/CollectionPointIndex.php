<?php

namespace Src\Recycling\CollectionPoint\UI\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Src\Recycling\CollectionPoint\Application\UseCases\DeleteCollectionPointUseCase;
use Src\Recycling\CollectionPoint\Application\UseCases\GetAllCollectionPointsUseCase;

class CollectionPointIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteCollectionPoint(string $id, DeleteCollectionPointUseCase $useCase): void
    {
        try {
            $useCase->execute($id);
            session()->flash('message', 'Punto de recogida eliminado con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    public function render(GetAllCollectionPointsUseCase $useCase)
    {
        $result = $useCase->execute();

        return view('livewire.recycling.collection-point.collection-point-index', [
            'collectionPoints' => $result['items'],
        ])->layout('layouts.app');
    }
}
