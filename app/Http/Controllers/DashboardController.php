<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Lugar;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración con estadísticas generales.
     *
     * @return View
     */
    public function index()
    {
        $totalUsuarios = User::count();
        $totalLugares = Lugar::count();
        $eventosActivos = Evento::where('activo', 1)->count();

        return view('admin.dashboard', compact('totalUsuarios', 'totalLugares', 'eventosActivos'));
    }
}
