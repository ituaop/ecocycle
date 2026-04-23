<?php

namespace Src\Recycling\WasteItem\UI\Livewire;

use Livewire\Component;
use Src\Recycling\WasteItem\Application\DTOs\CreateWasteItemDTO;
use Src\Recycling\WasteItem\Application\UseCases\CreateWasteItemUseCase;

class CreateWasteItemForm extends Component
{
    public ?string $id          = null;
    public string  $name        = '';
    public string  $description = '';
    public string  $category    = 'PLASTIC';
    public int     $points      = 0;

    public function submit(CreateWasteItemUseCase $useCase)
    {
        $this->validate([
            'name'        => 'required|min:2|max:100',
            'description' => 'required|min:10',
            'category'    => 'required',
            'points'      => 'required|integer|min:0',
        ]);

        try {
            $dto = new CreateWasteItemDTOs(
                $this->id,
                $this->name,
                $this->description,
                $this->category,
                $this->points
            );

            $useCase->execute($dto);

            session()->flash('success', '¡WasteItem creado con éxito!');
            return redirect()->route('recycling.waste-items.index');
        } catch (\Exception $e) {
            $this->addError('item_creation', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.recycling.waste-item.create-waste-item-form')->layout('layouts.app');
    }
}
