<?php

namespace Src\Recycling\WasteItem\UI\Livewire;

use Livewire\Component;
use Src\Recycling\WasteItem\Application\DTOs\CreateWasteItemDTO;
use Src\Recycling\WasteItem\Application\UseCases\ReadWasteItemUseCase;
use Src\Recycling\WasteItem\Application\UseCases\UpdateWasteItemUseCase;

class EditWasteItemForm extends Component
{
    public string $itemId      = '';
    public string $name        = '';
    public string $description = '';
    public string $category    = '';
    public int    $points      = 0;

    public function mount(string $id, ReadWasteItemUseCase $useCase): void
    {
        $item = $useCase->execute($id);

        $this->itemId      = $item->getIdValue();
        $this->name        = $item->getNameValue();
        $this->description = $item->getDescriptionValue();
        $this->category    = $item->getCategoryValue();
        $this->points      = $item->getPointsValue();
    }

    public function update(UpdateWasteItemUseCase $useCase)
    {
        $this->validate([
            'name'        => 'required|min:2|max:100',
            'description' => 'required|min:10',
            'category'    => 'required',
            'points'      => 'required|integer|min:0',
        ]);

        $dto = new CreateWasteItemDTOs(
            $this->itemId,
            $this->name,
            $this->description,
            $this->category,
            $this->points
        );

        $useCase->execute($dto);

        session()->flash('message', 'WasteItem actualizado correctamente.');
        return redirect()->route('recycling.waste-items.index');
    }

    public function render()
    {
        return view('livewire.recycling.waste-item.edit-waste-item-form')->layout('layouts.app');
    }
}
