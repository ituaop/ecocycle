<?php

namespace Src\Recycling\User\UI\Livewire;

use Livewire\Component;
use Src\Recycling\User\Application\DTOs\CreateUserDTO;
use Src\Recycling\User\Application\UseCases\CreateUserUseCase;

class CreateUserForm extends Component
{
    public ?string $id           = null;
    public string  $username     = '';
    public string  $email        = '';
    public string  $level        = 'BEGINNER';
    public int     $total_points = 0;

    public function submit(CreateUserUseCase $useCase)
    {
        $this->validate([
            'username' => 'required|min:3|max:50',
            'email'    => 'required|email',
            'level'    => 'required',
        ]);

        try {
            $dto = new CreateUserDTOs(
                $this->id,
                $this->username,
                $this->email,
                $this->level,
                $this->total_points
            );

            $useCase->execute($dto);

            session()->flash('success', '¡Usuario creado con éxito!');
            return redirect()->route('recycling.users.index');
        } catch (\Exception $e) {
            $this->addError('user_creation', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.recycling.user.create-user-form')->layout('layouts.app');
    }
}
