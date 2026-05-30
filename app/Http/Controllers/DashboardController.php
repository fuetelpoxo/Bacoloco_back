<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lugar;
use App\Models\Evento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración con estadísticas generales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalUsuarios = User::count();
        $totalLugares = Lugar::count();
        $eventosActivos = Evento::where('activo', 1)->count();

        return view('admin.dashboard', compact('totalUsuarios', 'totalLugares', 'eventosActivos'));
    }
}
