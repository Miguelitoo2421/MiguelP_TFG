<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;    // CRUD de usuarios
use App\Http\Controllers\CharacterController;     // controlador "plano" de Characters
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventCastController;
use App\Http\Controllers\DashboardController;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS y PERFIL
|--------------------------------------------------------------------------
*/
Route::get('/', function() {
    return view('welcome', [
        'events' => Event::with(['play', 'location'])->orderBy('scheduled_at')->take(5)->get()
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE ACTORES (accesibles para admin y user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('actors', [ActorController::class, 'index'])->name('actors.index');
    Route::get('actors/{actor}', [ActorController::class, 'show'])->name('actors.show');
    Route::patch('actors/{actor}', [ActorController::class, 'update'])->name('actors.update');
    
    // Rutas solo para admin
    Route::middleware('role:admin')->group(function () {
        Route::post('actors', [ActorController::class, 'store'])->name('actors.store');
        Route::delete('actors/{actor}', [ActorController::class, 'destroy'])->name('actors.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN: Gestión de Usuarios (nombres admin.*)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth','role:admin'])
     ->group(function() {
         Route::get    ('users',        [UserController::class,'index'])->name('users.index');
         Route::post   ('users',        [UserController::class,'store'])->name('users.store');
         Route::patch  ('users/{user}', [UserController::class,'update'])->name('users.update');
         Route::delete ('users/{user}', [UserController::class,'destroy'])->name('users.destroy');
     });

/*
|--------------------------------------------------------------------------
| ADMIN: CRUD de Catálogos
| - URL: /admin/{resource}
| - Rutas sin prefijo de nombre, para que usen characters.*, plays.*, etc.
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->middleware(['auth','role:admin'])
     ->group(function() {
         Route::resource('producers',  ProducerController::class);
         Route::resource('plays',      PlayController::class);
         Route::resource('characters', CharacterController::class);
         Route::resource('locations',  LocationController::class);
         Route::resource('events',     EventController::class);
         Route::post('events/{event}/casts', [EventCastController::class, 'store'])
              ->name('events.casts.store');
     });

Route::delete('/plays/{play}/characters/{character}', [PlayController::class, 'removeCharacter'])
    ->name('plays.characters.remove');

require __DIR__.'/auth.php';
