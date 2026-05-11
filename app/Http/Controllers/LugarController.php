<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Lugar;
use App\Models\Tipo;
use App\Models\User;
use Illuminate\Http\Request;

class LugarController extends Controller
{
    public function index(Request $request)
    {
        $filtros = $this->aplicarFiltros($request);

        $lugares = Lugar::withCount('eventos')
            ->where($filtros)
            ->paginate(10)
            ->withQueryString();

        $tipos = Tipo::pluck('nombre', 'id');
        return view('lugares.index', compact('lugares', 'tipos'));
    }

    public function create()
    {
        $tipos = Tipo::pluck('nombre', 'id');
        $users = User::pluck('nombre', 'id');

        return view('lugares.create', compact('tipos', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_id' => 'required|integer|exists:tipos,id',
            'user_id' => 'required|integer|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric|decimal:7',
            'longitud' => 'required|numeric|decimal:7',
            'municipio' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        // Crear el lugar
        $lugar = Lugar::create($data);

        // Procesar imágenes si existen
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $archivo) {
                // Guardar archivo en disco público
                $ruta = $archivo->store('lugares', 'public');

                // Crear registro de imagen
                $imagen = Imagen::create([
                    'ruta' => $ruta,
                    'tipo' => 'lugar',
                ]);

                // Asociar imagen al lugar
                $lugar->imagenes()->attach($imagen->id);
            }
        }

        return redirect()->route('lugares.index')->with('success', 'Lugar creado correctamente.');
    }

    public function edit(Lugar $lugar)
    {
        $lugar->load('imagenes');
        $tipos = Tipo::pluck('nombre', 'id');
        $users = User::pluck('nombre', 'id');

        return view('lugares.edit', compact('lugar', 'tipos', 'users'));
    }

    public function update(Request $request, Lugar $lugar)
    {
        $data = $request->validate([
            'tipo_id' => 'required|integer|exists:tipos,id',
            'user_id' => 'required|integer|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric|decimal:7',
            'longitud' => 'required|numeric|decimal:7',
            'municipio' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        $lugar->update($data);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $archivo) {
                $ruta = $archivo->store('lugares', 'public');

                $imagen = Imagen::create([
                    'ruta' => $ruta,
                    'tipo' => 'lugar',
                ]);

                $lugar->imagenes()->attach($imagen->id);
            }
        }

        return redirect()->route('lugares.index')->with('success', 'Lugar actualizado correctamente.');
    }

    public function destroy(Lugar $lugar)
    {
        $lugar->delete();

        return redirect()->route('lugares.index')->with('success', 'Lugar eliminado correctamente.');
    }

    private function aplicarFiltros(Request $request)
    {
        $filtros = [];

        if ($request->activo !== null && $request->activo !== '') {
            $filtros[] = ['activo', '=', $request->activo];
        }

        if ($request->tipo_id) {
            $filtros[] = ['tipo_id', '=', $request->tipo_id];
        }

        if ($request->municipio) {
            $filtros[] = ['municipio', '=', $request->municipio];
        }

        if ($request->nombre) {
            $filtros[] = ['nombre', 'like', '%' . $request->nombre . '%'];
        }

        return $filtros;
    }
}
