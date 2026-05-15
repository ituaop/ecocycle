<?php
use Src\Recycling\Rewards\UI\Controllers\Inertia\RewardsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Src\Recycling\User\UI\Controllers\Auth\LoginController;
use Src\Recycling\User\UI\Controllers\Auth\RegisterController;
use Src\Recycling\User\UI\Controllers\Inertia\ProfileController;
use Src\Recycling\RecycleAction\UI\Controllers\Inertia\RecycleController;
use Src\Recycling\CollectionPoint\UI\Controllers\Inertia\CollectionPointsController;
use Src\Recycling\Challenge\UI\Controllers\Inertia\ChallengeController;
use Src\Recycling\Challenge\UI\Controllers\Inertia\ClaimRewardController;
use Src\Recycling\Challenge\UI\Controllers\Inertia\JoinChallengeController;
use Src\Recycling\Social\UI\Controllers\Inertia\SocialController;
use Src\Recycling\Social\UI\Controllers\Inertia\CreateTeamController;
use Src\Recycling\Social\UI\Controllers\Inertia\JoinTeamController;
use Src\Recycling\Social\UI\Controllers\Inertia\LeaveTeamController;
use Src\Recycling\Leaderboard\UI\Controllers\Inertia\LeaderboardController;


Route::get('/', fn() => inertia('Welcome'))->name('home');

// auth —> solo guests
Route::middleware('guest')->group(function () {
    Route::get('/register',  [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login',     [LoginController::class,   'create'])->name('login');
    Route::post('/login',    [LoginController::class,   'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// rutas protegidas
Route::middleware('auth')->group(function () {

    // dashboard principal
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // recompensas
     Route::get('/rewards', RewardsController::class)->name('rewards');

    // flujo principal del usuario
    Route::get('/recycle',        [RecycleController::class, 'index']) ->name('recycle.index');
    Route::post('/recycle',       [RecycleController::class, 'store']) ->name('recycle.store');
    Route::get('/recycle/result', [RecycleController::class, 'result'])->name('recycle.result');

    // puntos de recogida 
    Route::get('/collection-points', [CollectionPointsController::class, 'index'])->name('collection-points.index');

    // perfil
    Route::get('/profile',          [ProfileController::class, 'show'])          ->name('profile.show');
    Route::patch('/profile',        [ProfileController::class, 'update'])         ->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']) ->name('profile.password');

    Route::get('/challenges',        ChallengeController::class)->name('challenges.index');
    Route::post('/challenges/join',  JoinChallengeController::class)->name('challenges.join');
    Route::post('/challenges/claim', ClaimRewardController::class)->name('challenges.claim');


    Route::get('/leaderboard', LeaderboardController::class)->name('leaderboard.index');


    Route::get('/social',          SocialController::class)->name('social.index');
        Route::post('/teams',          CreateTeamController::class)->name('teams.create');
        Route::post('/teams/join',     JoinTeamController::class)->name('teams.join');
        Route::post('/teams/leave',    LeaveTeamController::class)->name('teams.leave');
    });
