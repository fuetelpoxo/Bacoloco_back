<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\Auth\WebAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('eventos', EventoController::class)
        ->parameters(['eventos' => 'evento']);
    Route::resource('lugares', LugarController::class)
        ->parameters(['lugares' => 'lugar']);

    Route::delete('/imagenes/{imagen}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
});
Route::middleware(['auth', 'role:organizador'])->prefix('organizador')->group(function () {
    Route::resource('lugares', LugarController::class)
        ->parameters(['lugares' => 'lugar']);

    Route::delete('/imagenes/{imagen}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
});
