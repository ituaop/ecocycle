<?php

namespace Src\Recycling\CollectionPoint\Infraestructure\Traits;

use Src\Recycling\CollectionPoint\Infraestructure\Hydrators\CollectionPointHydrator;
use Src\Recycling\CollectionPoint\Infraestructure\Models\CollectionPointModel;

trait GetAllCollectionPointsTrait
{
    public function getAllCollectionPoints(
        string $order = 'name',
        string $direction = 'asc',
        int    $page = 1,
        int    $perPage = 10
    ): array {
        $paginator = CollectionPointModel::query()
            ->orderBy($order, $direction)
            ->paginate(perPage: $perPage, page: $page);

        return [
            'items'      => $paginator->getCollection()->map(fn($m) => CollectionPointHydrator::toDomain($m))->all(),
            'pagination' => [
                'total'       => $paginator->total(),
                'perPage'     => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage'    => $paginator->lastPage(),
            ],
        ];
    }

    public function getActiveCollectionPoints(): array
    {
        return CollectionPointModel::where('status', 'ACTIVE')
            ->orderBy('name')
            ->get()
            ->map(fn($m) => CollectionPointHydrator::toDomain($m))
            ->all();
    }
}
