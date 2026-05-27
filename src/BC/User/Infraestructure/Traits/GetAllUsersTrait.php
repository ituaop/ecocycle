<?php

namespace Src\Recycling\User\Infraestructure\Traits;

use Src\Recycling\User\Infraestructure\Hydrators\UserHydrator;
use Src\Recycling\User\Infraestructure\Models\UserModel;

trait GetAllUsersTrait
{
    public function getAllUsers(
        string $order = 'username',
        string $direction = 'asc',
        int    $page = 1,
        int    $perPage = 10
    ): array {
        $safeOrder     = trim($order)     !== '' ? $order     : 'username';
        $safeDirection = trim($direction) !== '' ? $direction : 'asc';

        $paginator = UserModel::query()
            ->orderBy($safeOrder, $safeDirection)
            ->paginate(perPage: $perPage, page: $page);

        return [
            'items'      => $paginator->getCollection()->map(fn($m) => UserHydrator::toDomain($m))->all(),
            'pagination' => [
                'total'       => $paginator->total(),
                'perPage'     => $paginator->perPage(),
                'currentPage' => $paginator->currentPage(),
                'lastPage'    => $paginator->lastPage(),
            ],
        ];
    }
}
