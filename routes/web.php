<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use \App\Http\Middleware\CheckActiveUser;
use App\Http\Controllers\FichasConsultaController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\TestimonioController;
use App\Http\Controllers\Admin\ContenidoController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\ActividadController;
use App\Models\Carousel;
use App\Models\Actividad;
use App\Models\Testimonio;
use App\Models\Contenido;
use App\Http\Controllers\CasoController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    $slides = Carousel::orderBy('orden')->get();
    $actividades = Actividad::latest()->take(6)->get();
    $testimonios = Testimonio::latest()->take(6)->get();
    $contenidos = Contenido::all();

    return view('welcome', compact('slides', 'actividades', 'testimonios', 'contenidos'));
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

    //RUTAS PARA GESTION DE CONTENIDO
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::resource('carousels', Admin\CarouselController::class);
        Route::resource('actividades', Admin\ActividadController::class)->parameters([
            'actividades' => 'actividad'
        ]);
        Route::resource('testimonios', Admin\TestimonioController::class);
        Route::resource('contenidos', Admin\ContenidoController::class);
    });


    // Rutas para FICHAS DE CONSULTA - PACIENTES
    Route::get('fichasConsulta', [FichasConsultaController::class, 'index'])->name('fichasConsulta.index');
    Route::get('fichasConsulta/create', [FichasConsultaController::class, 'create'])->name('fichasConsulta.create');
    Route::post('fichasConsulta', [FichasConsultaController::class, 'store'])->name('fichasConsulta.store');
    Route::get('fichasConsulta/{ficha}/edit', [FichasConsultaController::class, 'edit'])->name('fichasConsulta.edit');
    Route::put('fichasConsulta/{ficha}', [FichasConsultaController::class, 'update'])->name('fichasConsulta.update');
    // Route::delete('fichasConsulta/{ficha}', [FichasConsultaController::class, 'destroy'])->name('fichasConsulta.destroy');

    // Ruta FORMULARIO SITUACION DE VIOLENCIA INTRAFAMILIAR
    Route::get('/casos', [CasoController::class, 'index'])->name('casos.index');
    Route::get('/casos/create', [CasoController::class, 'create'])->name('casos.create');
    Route::post('/casos', [CasoController::class, 'store'])->name('casos.store');
    //Route::get('/casos/{caso}', [CasoController::class,'show'])->name('casos.show');
    Route::get('/casos/{caso}/edit', [CasoController::class, 'edit'])->name('casos.edit');
    Route::put('/casos/{caso}', [CasoController::class, 'update'])->name('casos.update');
    //Route::delete('/casos/{caso}', [CasoController::class,'destroy'])->name('casos.destroy');

    Route::get('/casos/numero/proximo', [CasoController::class, 'obtenerProximoNumero'])->name('casos.proximo-numero');
    Route::post('/casos/numero/validar', [CasoController::class, 'validarNumeroRegistro'])->name('casos.validar-numero');
});

require __DIR__ . '/auth.php';
