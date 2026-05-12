<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lugar;
use App\Models\Evento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalLugares = Lugar::count();
        // Asumiendo que la columna isActive o activo determina si el evento está activo.
        // En vistas anteriores se veía el campo "activo"
        $eventosActivos = Evento::where('activo', 1)->count();

        return view('dashboard', compact('totalUsuarios', 'totalLugares', 'eventosActivos'));
    }
}
