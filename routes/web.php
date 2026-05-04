<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\LugarController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LugarController::class, 'index']);
// Route::get('/Usuarios', [LugarController::class, 'index']);
// Route::get('/Valoraciones', [LugarController::class, 'index']);
Route::resource('eventos', EventoController::class)
    ->parameters(['eventos' => 'evento']);
Route::resource('lugares', LugarController::class)
    ->parameters(['lugares' => 'lugar']);
