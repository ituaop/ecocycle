<?php

namespace Src\Recycling\Social\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Recycling\Social\Application\UseCases\LeaveTeamUseCase;

class LeaveTeamController extends Controller
{
    public function __construct(private LeaveTeamUseCase $leaveTeam) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate(['team_id' => 'required|uuid']);
        $this->leaveTeam->execute(Auth::id(), $request->team_id);
        return back()->with('success', 'Has salido del equipo.');
    }
}
