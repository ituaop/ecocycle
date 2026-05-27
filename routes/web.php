<?php
use Src\BC\Rewards\UI\Controllers\Inertia\RewardsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Src\BC\User\UI\Controllers\Auth\LoginController;
use Src\BC\User\UI\Controllers\Auth\RegisterController;
use Src\BC\User\UI\Controllers\Inertia\ProfileController;
use Src\BC\RecycleAction\UI\Controllers\Inertia\RecycleController;
use Src\BC\CollectionPoint\UI\Controllers\Inertia\CollectionPointsController;
use Src\BC\Challenge\UI\Controllers\Inertia\ChallengeController;
use Src\BC\Challenge\UI\Controllers\Inertia\ClaimRewardController;
use Src\BC\Challenge\UI\Controllers\Inertia\JoinChallengeController;
use Src\BC\Social\UI\Controllers\Inertia\SocialController;
use Src\BC\Social\UI\Controllers\Inertia\CreateTeamController;
use Src\BC\Social\UI\Controllers\Inertia\JoinTeamController;
use Src\BC\Social\UI\Controllers\Inertia\LeaveTeamController;
use Src\BC\Leaderboard\UI\Controllers\Inertia\LeaderboardController;


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

   
    });
