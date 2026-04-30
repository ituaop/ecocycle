<?php

namespace Src\Recycling\User\UI\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Src\Recycling\User\Application\DTOs\RegisterUserDTO;
use Src\Recycling\User\Application\UseCases\RegisterUserUseCase;
use Src\Recycling\User\Infraestructure\Models\UserAuthModel;
use Src\Recycling\User\UI\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function __construct(private RegisterUserUseCase $useCase) {}

    /** GET /register */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /** POST /register */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        try {
            $dto = new RegisterUserDTO(
                name:                 $request->input('name'),
                email:                $request->input('email'),
                plainPassword:        $request->input('password'),
                passwordConfirmation: $request->input('password_confirmation')
            );

            $domainUser = $this->useCase->execute($dto);

            // Login automático con el modelo Eloquent Authenticatable
            $authModel = UserAuthModel::find($domainUser->getIdValue());
            Auth::login($authModel, remember: false);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));

        } catch (Exception $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }
}
