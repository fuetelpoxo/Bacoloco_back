<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizadorController;
use App\Http\Controllers\Auth\WebAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Redirigir la raíz al login (así si no ponen url exacta, los manda al login)
Route::get('/', function () {
    return redirect()->route('login');
});

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
    Route::get('/dashboard', [OrganizadorController::class, 'dashboard'])->name('organizador.dashboard');
    Route::post('/valoraciones/{valoracionId}/reportar', [OrganizadorController::class, 'reportarValoracion'])->name('valoraciones.reportar');
    
    Route::resource('eventos', EventoController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['eventos' => 'evento']);
    
    Route::resource('lugares', LugarController::class)
        ->parameters(['lugares' => 'lugar']);

    Route::delete('/imagenes/{imagen}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
});
