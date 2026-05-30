<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizadorController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Redirigir la raíz al front en React
Route::get('/', function () {
    return redirect(config('app.frontend_url'));
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('eventos', EventoController::class)
        ->parameters(['eventos' => 'evento']);
    Route::resource('lugares', LugarController::class)
        ->parameters(['lugares' => 'lugar']);
    Route::resource('usuarios', UserController::class)
        ->parameters(['usuarios' => 'usuario']);
    Route::resource('valoraciones', ValoracionController::class)
        ->parameters(['valoraciones' => 'valoracion']);
    Route::delete('/imagenes/{imagen}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
});

Route::middleware(['auth', 'role:organizador'])->prefix('organizador')->group(function () {
    Route::get('/', [OrganizadorController::class, 'dashboard'])->name('organizador.dashboard');
    Route::post('/valoraciones/{valoracionId}/reportar', [OrganizadorController::class, 'reportarValoracion'])->name('valoraciones.reportar');

    Route::resource('eventos', EventoController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['eventos' => 'evento'])
        ->names('organizador.eventos');

    Route::delete('/imagenes/{imagen}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
});
