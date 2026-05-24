<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Evento;
use App\Models\Lugar;
use App\Models\User;
use App\Models\Etiqueta;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.create', compact('lugares', 'users', 'etiquetas'));
    }

    public function store(Request $request, ImageService $imageService)
    {
        // 1. Condicionar la regla del user_id (igual que en tu update)
        $userIdRule = Auth::user()->rol === 'organizador' ? 'nullable' : 'required|integer|exists:users,id';

        $data = $request->validate([
            'lugar_id' => 'nullable|integer|exists:lugares,id',
            'user_id' => $userIdRule,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'precio' => 'nullable|numeric|min:0',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array|max:3',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
            'etiquetas' => 'nullable|array|max:4',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        return DB::transaction(function () use ($request, $data, $imageService) {
            // Si es organizador, validar que el lugar le pertenece y auto-asignar user_id
            if (Auth::user()->rol === 'organizador') {
                if ($data['lugar_id'] ?? null) {
                    $lugar = Lugar::findOrFail($data['lugar_id']);
                    if ($lugar->user_id !== Auth::id()) {
                        return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para crear eventos en este lugar.');
                    }
                }
                $data['user_id'] = Auth::id();
            }

            $evento = Evento::create($data);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $archivo) {
                    // Guardar la imagen en storage/app/public/eventos
                    $ruta = $imageService->optimizarYGuardar($archivo, 'eventos');

                    $imagen = Imagen::create([
                        'ruta' => $ruta,
                        'tipo' => 'evento',
                    ]);

                    // Relacionar la imagen con el evento
                    $evento->imagenes()->attach($imagen->id);
                }
            }

            // Asociar etiquetas
            if ($request->has('etiquetas')) {
                $evento->etiquetas()->attach($request->input('etiquetas'));
            }

            // 2. Redireccionar directamente dónde queremos que acabe, sin confusiones
            if (Auth::user()->rol === 'organizador') {
                return redirect()->route('organizador.dashboard')->with('success', 'Evento creado correctamente.');
            }

            return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
        });
    }

    public function edit(Evento $evento)
    {
        if (Auth::user()->rol === 'organizador' && $evento->user_id !== Auth::id()) {
            return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para editar este evento.');
        }

        $evento->load(['imagenes', 'etiquetas']);

        // Condicionar los lugares según el rol
        if (Auth::user()->rol === 'organizador') {
            $lugares = Lugar::where('user_id', Auth::id())->orderBy('nombre')->pluck('nombre', 'id');
        } else {
            $lugares = Lugar::orderBy('nombre')->pluck('nombre', 'id');
        }

        $users = User::orderBy('nombre')->pluck('nombre', 'id');
        $etiquetas = Etiqueta::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.eventos.edit', compact('evento', 'lugares', 'users', 'etiquetas'));
    }

    public function update(Request $request, Evento $evento, ImageService $imageService)
    {
        // Verificar que el organizador solo puede editar sus propios eventos
        if (Auth::user()->rol === 'organizador' && $evento->user_id !== Auth::id()) {
            return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para editar este evento.');
        }

        // Validación condicional: user_id es requerido solo si no es organizador
        $userIdRule = Auth::user()->rol === 'organizador' ? 'nullable' : 'required|integer|exists:users,id';

        $data = $request->validate([
            'lugar_id' => 'nullable|integer|exists:lugares,id',
            'user_id' => $userIdRule,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'precio' => 'nullable|numeric|min:0',
            'activo' => 'sometimes|boolean',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
            'etiquetas' => 'nullable|array|max:4',
            'etiquetas.*' => 'integer|exists:etiquetas,id',
        ]);

        return DB::transaction(function () use ($request, $data, $evento, $imageService) {
            // Si es organizador, validar que el lugar le pertenece y mantener user_id
            if (Auth::user()->rol === 'organizador') {
                if ($data['lugar_id'] ?? null) {
                    $lugar = Lugar::findOrFail($data['lugar_id']);
                    if ($lugar->user_id !== Auth::id()) {
                        return redirect()->route('organizador.dashboard')->with('error', 'No tienes permiso para usar este lugar.');
                    }
                }
                $data['user_id'] = Auth::id();
            }

            $evento->update($data);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $archivo) {
                    $ruta = $imageService->optimizarYGuardar($archivo, 'eventos');

                    $imagen = Imagen::create([
                        'ruta' => $ruta,
                        'tipo' => 'evento',
                    ]);

                    $evento->imagenes()->attach($imagen->id);
                }
            }

            // Sincronizar etiquetas
            $evento->etiquetas()->sync($request->input('etiquetas', []));

            if (Auth::user()->rol === 'organizador') {
                return redirect()->route('organizador.dashboard')->with('success', 'Evento actualizado correctamente.');
            }
            return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
        });
    }

    public function destroy(Evento $evento)
    {
        // Verificar que el organizador solo puede eliminar sus propios eventos
        if (Auth::user()->rol === 'organizador' && $evento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este evento.');
        }

        $evento->delete();

        if (Auth::user()->rol === 'organizador') {
            return redirect()->route('organizador.dashboard')->with('success', 'Evento eliminado correctamente.');
        }
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
