<?php

namespace Src\Recycling\Challenge\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Recycling\Challenge\Application\UseCases\JoinChallengeUseCase;

class JoinChallengeController extends Controller
{
    public function __construct(private JoinChallengeUseCase $joinChallenge) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate(['challenge_id' => 'required|uuid']);

        $this->joinChallenge->execute(Auth::id(), $request->challenge_id);

        return back()->with('success', '¡Te has unido al reto!');
    }
}

