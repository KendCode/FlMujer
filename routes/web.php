<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use \App\Http\Middleware\CheckActiveUser;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prueba', function () {
    return 'Middleware funcionando ccccccc';
})->middleware(CheckActiveUser::class);

// Dashboard protegido: autenticado, email verificado y usuario activo
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', CheckActiveUser::class])->name('dashboard');

// Grupo de rutas protegidas por autenticación y usuario activo
Route::middleware(['auth', CheckActiveUser::class])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

require __DIR__.'/auth.php';
