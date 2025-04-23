<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\ProducerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PERFIL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN: Gestión de usuarios
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin'])
    ->group(function(){
        Route::get    ('users',        [UserController::class,'index'])->name('users.index');
        Route::post   ('users',        [UserController::class,'store'])->name('users.store');
        Route::patch  ('users/{user}', [UserController::class,'update'])->name('users.update');
        Route::delete ('users/{user}', [UserController::class,'destroy'])->name('users.destroy');

        
    });

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN: CRUD de Catálogos (sólo admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function(){
    Route::resource('producers',  ProducerController::class);
    Route::resource('plays',      PlayController::class);
    Route::resource('characters', CharacterController::class);
    Route::resource('actors',     ActorController::class);
    Route::resource('locations',  LocationController::class);
});
