<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// RUTAS PARA ADMIN:
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin'])
    ->group(function(){
        // Mostrar la tabla de usuarios
        Route::get('users', [UserController::class,'index'])
             ->name('users.index');
        // Procesar el formulario de cambio de roles
        Route::post('users/{user}/roles', [UserController::class,'updateRoles'])
             ->name('users.updateRoles');
    });


require __DIR__.'/auth.php';
