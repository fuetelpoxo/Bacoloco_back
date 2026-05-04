<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\LugarController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LugarController::class, 'index']);
Route::get('eventos', [EventoController::class, 'index']);
// Route::get('/Usuarios', [LugarController::class, 'index']);
// Route::get('/Valoraciones', [LugarController::class, 'index']);
Route::resource('lugares', LugarController::class)
    ->parameters(['lugares' => 'lugar']);
