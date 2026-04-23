<?php

namespace Src\Recycling\CollectionPoint\UI\Livewire;

use Livewire\Component;
use Src\Recycling\CollectionPoint\Application\DTOs\CreateCollectionPointDTO;
use Src\Recycling\CollectionPoint\Application\UseCases\CreateCollectionPointUseCase;

class CreateCollectionPointForm extends Component
{
    public ?string $id        = null;
    public string  $name      = '';
    public string  $address   = '';
    public float   $latitude  = 0.0;
    public float   $longitude = 0.0;
    public string  $status    = 'ACTIVE';

    public function submit(CreateCollectionPointUseCase $useCase)
    {
        $this->validate([
            'name'      => 'required|min:3|max:150',
            'address'   => 'required|min:5',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status'    => 'required',
        ]);

        try {
            $dto = new CreateCollectionPointDTOs(
                $this->id,
                $this->name,
                $this->address,
                $this->latitude,
                $this->longitude,
                $this->status
            );

            $useCase->execute($dto);

            session()->flash('success', '¡Punto de recogida creado con éxito!');
            return redirect()->route('recycling.collection-points.index');
        } catch (\Exception $e) {
            $this->addError('cp_creation', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.recycling.collection-point.create-collection-point-form')->layout('layouts.app');
    }
}
