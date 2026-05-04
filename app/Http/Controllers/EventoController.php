<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {

        $eventos = Evento::with('lugar')->get();

        return view('eventos.index', compact('eventos'));
 

    }

    public function add()
    {
        
    }
}
