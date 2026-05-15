<?php

namespace Src\Recycling\Social\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Recycling\Social\Application\UseCases\CreateFeedEntryUseCase;
use Src\Recycling\Social\Application\UseCases\JoinTeamUseCase;

class JoinTeamController extends Controller
{
    public function __construct(
        private JoinTeamUseCase       $joinTeam,
        private CreateFeedEntryUseCase $createFeedEntry,
    ) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate(['team_id' => 'required|uuid']);

        $member = $this->joinTeam->execute(Auth::id(), $request->team_id);

        // Publicar en el feed
        $this->createFeedEntry->execute(
            userId:      Auth::id(),
            type:        'TEAM_JOINED',
            title:       Auth::user()->name . ' se unió al equipo',
            points:      0,
            teamId:      $request->team_id,
        );

        return back()->with('success', '¡Te has unido al equipo!');
    }
}
