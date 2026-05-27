<?php

namespace Src\Recycling\RecycleAction\Infraestructure\Traits;

use Src\Recycling\RecycleAction\Infraestructure\Hydrators\RecycleActionHydrator;
use Src\Recycling\RecycleAction\Infraestructure\Models\RecycleActionModel;

trait GetAllRecycleActionsTrait
{
    public function getAllRecycleActions(
        string $order = 'date',
        string $direction = 'desc',
        int    $page = 1,
        int    $perPage = 10
    ): array {
        $paginator = RecycleActionModel::query()
            ->orderBy($order, $direction)
            ->paginate(perPage: $perPage, page: $page);

        return [
            'items'      => $paginator->getCollection()->map(fn($m) => RecycleActionHydrator::toDomain($m))->all(),
            'pagination' => [
                'total'       => $paginator->total(),
                'perPage'     => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage'    => $paginator->lastPage(),
            ],
        ];
    }

    public function getAllByUserId(
        string $userId,
        string $order = 'date',
        string $direction = 'desc',
        int    $page = 1,
        int    $perPage = 10
    ): array {
        $paginator = RecycleActionModel::where('user_id', $userId)
            ->orderBy($order, $direction)
            ->paginate(perPage: $perPage, page: $page);

        return [
            'items'      => $paginator->getCollection()->map(fn($m) => RecycleActionHydrator::toDomain($m))->all(),
            'pagination' => [
                'total'       => $paginator->total(),
                'perPage'     => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage'    => $paginator->lastPage(),
            ],
        ];
    }

    public function getAllByCollectionPointId(
        string $collectionPointId,
        int    $page = 1,
        int    $perPage = 10
    ): array {
        $paginator = RecycleActionModel::where('collection_point_id', $collectionPointId)
            ->orderBy('date', 'desc')
            ->paginate(perPage: $perPage, page: $page);

        return [
            'items'      => $paginator->getCollection()->map(fn($m) => RecycleActionHydrator::toDomain($m))->all(),
            'pagination' => [
                'total'       => $paginator->total(),
                'perPage'     => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage'    => $paginator->lastPage(),
            ],
        ];
    }
}
