<?php

use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\FavoritosController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ValoracionesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LugarController;

//RUTAS API AUTENTICACION
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});

//RUTAS API LUGARES
Route::prefix('lugares')->controller(LugarController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/mapa', 'getDatosMapa');
    Route::get('/{id}', 'show');
});


//RUTAS API EVENTOS
Route::prefix('eventos')->controller(EventoController::class)->group(function () {
    Route::get('/{id}', 'show');
});


//RUTAS API FAVORITOS
Route::middleware('auth:sanctum')->prefix('favoritos')->controller(FavoritosController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('/usuario', 'index');
    Route::delete('/{id}', 'destroy');
});

//RUTAS API VALORACIONES
Route::middleware('auth:sanctum')->prefix('valoraciones')->controller(ValoracionesController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

//RUTAS API USUARIO
Route::middleware('auth:sanctum')->prefix('usuario')->controller(UserController::class)->group(function () {
    Route::get('/{id}', 'show');
    Route::put('/', 'update');
    Route::put('/password', 'changePassword');
    Route::delete('/', 'destroy');
});
