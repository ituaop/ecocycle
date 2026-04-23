<?php

namespace Src\Recycling\CollectionPoint\UI\Livewire;

use Livewire\Component;
use Src\Recycling\CollectionPoint\Application\DTOs\CreateCollectionPointDTO;
use Src\Recycling\CollectionPoint\Application\UseCases\ReadCollectionPointUseCase;
use Src\Recycling\CollectionPoint\Application\UseCases\UpdateCollectionPointUseCase;

class EditCollectionPointForm extends Component
{
    public string $cpId      = '';
    public string $name      = '';
    public string $address   = '';
    public float  $latitude  = 0.0;
    public float  $longitude = 0.0;
    public string $status    = '';

    public function mount(string $id, ReadCollectionPointUseCase $useCase): void
    {
        $cp = $useCase->execute($id);

        $this->cpId      = $cp->getIdValue();
        $this->name      = $cp->getNameValue();
        $this->address   = $cp->getAddressValue();
        $this->latitude  = $cp->getLatitudeValue();
        $this->longitude = $cp->getLongitudeValue();
        $this->status    = $cp->getStatusValue();
    }

    public function update(UpdateCollectionPointUseCase $useCase)
    {
        $this->validate([
            'name'      => 'required|min:3|max:150',
            'address'   => 'required|min:5',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status'    => 'required',
        ]);

        $dto = new CreateCollectionPointDTOs(
            $this->cpId,
            $this->name,
            $this->address,
            $this->latitude,
            $this->longitude,
            $this->status
        );

        $useCase->execute($dto);

        session()->flash('message', 'Punto de recogida actualizado correctamente.');
        return redirect()->route('recycling.collection-points.index');
    }

    public function render()
    {
        return view('livewire.recycling.collection-point.edit-collection-point-form')->layout('layouts.app');
    }
}
