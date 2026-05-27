<?php

namespace Src\Recycling\WasteItem\Infraestructure\Traits;

use Src\Recycling\WasteItem\Infraestructure\Hydrators\WasteItemHydrator;
use Src\Recycling\WasteItem\Infraestructure\Models\WasteItemModel;

trait GetAllWasteItemsTrait
{
    public function getAllWasteItems(
        string $order = 'name',
        string $direction = 'asc',
        int    $page = 1,
        int    $perPage = 10
    ): array {
        $paginator = WasteItemModel::query()
            ->orderBy($order, $direction)
            ->paginate(perPage: $perPage, page: $page);

        return [
            'items'      => $paginator->getCollection()->map(fn($m) => WasteItemHydrator::toDomain($m))->all(),
            'pagination' => [
                'total'       => $paginator->total(),
                'perPage'     => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage'    => $paginator->lastPage(),
            ],
        ];
    }

    public function getByCategory(string $category): array
    {
        return WasteItemModel::where('category', strtoupper($category))
            ->orderBy('name')
            ->get()
            ->map(fn($m) => WasteItemHydrator::toDomain($m))
            ->all();
    }
}
