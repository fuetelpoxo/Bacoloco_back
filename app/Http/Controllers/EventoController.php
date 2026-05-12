<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Evento;
use App\Models\Lugar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::with(['lugar', 'user'])
            ->where($this->aplicarFiltros($request))
            ->orderByDesc('fecha_inicio')
            ->paginate(10)
            ->withQueryString();

        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.index', compact('eventos', 'lugares'));
    }

    public function create()
    {
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $users = User::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.create', compact('lugares', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lugar_id' => 'nullable|integer|exists:lugares,id',
            'user_id' => 'required|integer|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'precio' => 'nullable|numeric|min:0',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        $evento = Evento::create($data);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $archivo) {
                $ruta = $archivo->store('eventos', 'public');

                $imagen = Imagen::create([
                    'ruta' => $ruta,
                    'tipo' => 'evento',
                ]);

                $evento->imagenes()->attach($imagen->id);
            }
        }

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
    }

    public function edit(Evento $evento)
    {
        $evento->load('imagenes');
        $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        $users = User::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.edit', compact('evento', 'lugares', 'users'));
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'lugar_id' => 'nullable|integer|exists:lugares,id',
            'user_id' => 'required|integer|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'precio' => 'nullable|numeric|min:0',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        $evento->update($data);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $archivo) {
                $ruta = $archivo->store('eventos', 'public');

                $imagen = Imagen::create([
                    'ruta' => $ruta,
                    'tipo' => 'evento',
                ]);

                $evento->imagenes()->attach($imagen->id);
            }
        }

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente.');
    }

    private function aplicarFiltros(Request $request)
    {
        $filtros = [];

        if ($request->nombre_evento) {
            $filtros[] = ['nombre', 'like', '%' . $request->nombre_evento . '%'];
        }

        if ($request->precio_desde) {
            $filtros[] = ['precio', '>=', $request->precio_desde];
        }

        if ($request->precio_hasta) {
            $filtros[] = ['precio', '<=', $request->precio_hasta];
        }

        if ($request->activo !== null && $request->activo !== '') {
            $filtros[] = ['activo', '=', $request->activo];
        }

        return $filtros;
    }
}
