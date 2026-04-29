<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Src\Recycling\User\UI\Controllers\Auth\LoginController;
use Src\Recycling\User\UI\Controllers\Auth\RegisterController;
use Src\Recycling\User\UI\Controllers\Inertia\ProfileController;
use Src\Recycling\RecycleAction\UI\Controllers\Inertia\RecycleController;
use Src\Recycling\CollectionPoint\UI\Controllers\Inertia\CollectionPointsController;

// Landing pública
Route::get('/', fn() => inertia('Welcome'))->name('home');

// Auth — solo guests
Route::middleware('guest')->group(function () {
    Route::get('/register',  [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login',     [LoginController::class,   'create'])->name('login');
    Route::post('/login',    [LoginController::class,   'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Reciclar — flujo principal del usuario
    Route::get('/recycle',        [RecycleController::class, 'index']) ->name('recycle.index');
    Route::post('/recycle',       [RecycleController::class, 'store']) ->name('recycle.store');
    Route::get('/recycle/result', [RecycleController::class, 'result'])->name('recycle.result');

    // Puntos de recogida — solo lectura para el usuario
    Route::get('/collection-points', [CollectionPointsController::class, 'index'])->name('collection-points.index');

    // Perfil
    Route::get('/profile',          [ProfileController::class, 'show'])          ->name('profile.show');
    Route::patch('/profile',        [ProfileController::class, 'update'])         ->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']) ->name('profile.password');
});
