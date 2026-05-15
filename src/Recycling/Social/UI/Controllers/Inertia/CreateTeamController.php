<?php

namespace Src\Recycling\Social\UI\Controllers\Inertia;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Recycling\Social\Application\DTOs\CreateTeamDTO;
use Src\Recycling\Social\Application\UseCases\CreateTeamUseCase;

class CreateTeamController extends Controller
{
    public function __construct(private CreateTeamUseCase $createTeam) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string|min:3|max:50',
            'description' => 'nullable|string|max:200',
            'emoji'       => 'nullable|string|max:5',
            'badge_color' => 'nullable|string|max:10',
            'is_public'   => 'boolean',
        ]);

        $this->createTeam->execute(new CreateTeamDTO(
            id:          null,
            name:        $request->name,
            slug:        '',           
            description: $request->description,
            emoji:       $request->emoji       ?? '♻️',
            badgeColor:  $request->badge_color ?? '#2d6a4f',
            ownerId:     Auth::id(),
            isPublic:    (bool) $request->input('is_public', true),
            maxMembers:  20,
        ));

        return redirect()->route('social.index')->with('success', '¡Equipo creado!');
    }
}
