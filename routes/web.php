<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use \App\Http\Middleware\CheckActiveUser;
use App\Http\Controllers\FichasConsultaController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');
Route::get('/testimonios', [PageController::class, 'testimonios'])->name('testimonios');
Route::get('/actividades', [PageController::class, 'actividades'])->name('actividades');

// Dashboard protegido: autenticado, email verificado y usuario activo
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', CheckActiveUser::class])->name('dashboard');

// Grupo de rutas protegidas por autenticación y usuario activo
Route::middleware(['auth', CheckActiveUser::class])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])
    ->name('profile.update.photo');

// Rutas para USUARIOS - FUNCIONARIOS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

// Rutas para FICHAS DE CONSULTA - PACIENTES
    Route::get('fichasConsulta', [FichasConsultaController::class, 'index'])->name('fichasConsulta.index');
});

require __DIR__.'/auth.php';
