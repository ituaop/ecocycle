<?php

namespace Src\Recycling\User\UI\Livewire;

use Livewire\Component;
use Src\Recycling\User\Application\DTOs\CreateUserDTO;
use Src\Recycling\User\Application\UseCases\ReadUserUseCase;
use Src\Recycling\User\Application\UseCases\UpdateUserUseCase;

class EditUserForm extends Component
{
    public string $userId       = '';
    public string $username     = '';
    public string $email        = '';
    public string $level        = '';
    public int    $total_points = 0;

    public function mount(string $id, ReadUserUseCase $useCase): void
    {
        $user = $useCase->execute($id);

        $this->userId       = $user->getIdValue();
        $this->username     = $user->getUsernameValue();
        $this->email        = $user->getEmailValue();
        $this->level        = $user->getLevelValue();
        $this->total_points = $user->getTotalPointsValue();
    }

    public function update(UpdateUserUseCase $useCase)
    {
        $this->validate([
            'username' => 'required|min:3|max:50',
            'email'    => 'required|email',
            'level'    => 'required',
        ]);

        $dto = new CreateUserDTOs(
            $this->userId,
            $this->username,
            $this->email,
            $this->level,
            $this->total_points
        );

        $useCase->execute($dto);

        session()->flash('message', 'Usuario actualizado correctamente.');
        return redirect()->route('recycling.users.index');
    }

    public function render()
    {
        return view('livewire.recycling.user.edit-user-form')->layout('layouts.app');
    }
}
