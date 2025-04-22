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
     /*
        Route::get('users',             [UserController::class,'index'])->name('users.index');
        Route::get('users/create',      [UserController::class,'create'])->name('users.create');
        Route::get('users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
        Route::patch('users/{user}',    [UserController::class,'update'])->name('users.update');
        Route::post('users',            [UserController::class,'store'])->name('users.store');
        Route::delete('users/{user}',   [UserController::class,'destroy'])->name('users.destroy');
     */   

        Route::get  ('users',          [UserController::class,'index'])->name('users.index');
        Route::post ('users',          [UserController::class,'store'])->name('users.store');
        Route::patch('users/{user}',   [UserController::class,'update'])->name('users.update');
        Route::delete('users/{user}',  [UserController::class,'destroy'])->name('users.destroy');
    });

require __DIR__.'/auth.php';
