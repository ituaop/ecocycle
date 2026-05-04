<?php

namespace Src\Recycling\User\UI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Recycling\User\Application\UseCases\DeleteUserUseCase;

class DeleteUserController extends Controller
{
    public function __construct(private DeleteUserUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->useCase->execute($id);

            return response()->json([
                'status'  => 'deleted',
                'message' => 'Usuario eliminado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
