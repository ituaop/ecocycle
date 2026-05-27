<?php

namespace Src\Recycling\CollectionPoint\UI\Livewire;

use Livewire\Component;
use Src\Recycling\CollectionPoint\Application\DTOs\CreateCollectionPointDTO;
use Src\Recycling\CollectionPoint\Application\UseCases\ReadCollectionPointUseCase;
use Src\Recycling\CollectionPoint\Application\UseCases\UpdateCollectionPointUseCase;

class EditCollectionPointForm extends Component
{
    public string  $cpId      = '';
    public string  $name      = '';
    public string  $address   = '';
    public float   $latitude  = 0.0;
    public float   $longitude = 0.0;
    public string  $status    = '';
    public ?string $schedule  = null;

    public function mount(string $id, ReadCollectionPointUseCase $useCase): void
    {
        $cp = $useCase->execute($id);

        $this->cpId      = $cp->getIdValue();
        $this->name      = $cp->getNameValue();
        $this->address   = $cp->getAddressValue();
        $this->latitude  = $cp->getLatitudeValue();
        $this->longitude = $cp->getLongitudeValue();
        $this->status    = $cp->getStatusValue();
        $this->schedule  = $cp->getScheduleValue();
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

        $dto = new CreateCollectionPointDTO(
            id:                 $this->cpId,
            name:               $this->name,
            address:            $this->address,
            latitude:           $this->latitude,
            longitude:          $this->longitude,
            status:             $this->status,
            schedule:           $this->schedule,
            acceptedCategories: []
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
