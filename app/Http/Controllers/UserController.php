<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filtros = $this->aplicarFiltros($request);

        $usuarios = User::where($filtros)
            ->paginate(10)
            ->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request, ImageService $imageService)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|string|in:admin,organizador,usuario',
            'avatar' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        // Hash la contraseña
        $data['password'] = Hash::make($data['password']);

        // Procesar logo/avatar si existe
        if ($request->hasFile('avatar')) {
            $ruta = $imageService->optimizarYGuardar($request->file('avatar'), 'usuarios/logos', 400);
            $data['avatar'] = $ruta;
        }

        User::create($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario, ImageService $imageService)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6|confirmed',
            'rol' => 'required|string|in:admin,organizador,usuario',
            'avatar' => 'nullable|image|max:2048|mimes:jpeg,png,gif,webp',
        ]);

        // Si la contraseña está vacía, no incluirla en los datos a actualizar
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        // Procesar nuevo avatar si existe
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($usuario->avatar) {
                Storage::disk('public')->delete($usuario->avatar);
            }

            $ruta = $imageService->optimizarYGuardar($request->file('avatar'), 'usuarios/logos', 400);
            $data['avatar'] = $ruta;
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        // Eliminar avatar si existe
        if ($usuario->avatar) {
            Storage::disk('public')->delete($usuario->avatar);
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    private function aplicarFiltros(Request $request)
    {
        $filtros = [];

        if ($request->nombre) {
            $filtros[] = ['nombre', 'like', '%' . $request->nombre . '%'];
        }

        if ($request->email) {
            $filtros[] = ['email', 'like', '%' . $request->email . '%'];
        }

        if ($request->rol) {
            $filtros[] = ['rol', '=', $request->rol];
        }

        return $filtros;
    }
}
