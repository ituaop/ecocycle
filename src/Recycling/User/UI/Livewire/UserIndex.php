<?php

namespace Src\Recycling\User\UI\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Src\Recycling\User\Application\UseCases\DeleteUserUseCase;
use Src\Recycling\User\Application\UseCases\GetAllUsersUseCase;

class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteUser(string $id, DeleteUserUseCase $useCase): void
    {
        try {
            $useCase->execute($id);
            session()->flash('message', 'Usuario eliminado con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    public function render(GetAllUsersUseCase $useCase)
    {
        $result = $useCase->execute();

        return view('livewire.recycling.user.user-index', [
            'users' => $result['items'],
        ]);
    }
}
