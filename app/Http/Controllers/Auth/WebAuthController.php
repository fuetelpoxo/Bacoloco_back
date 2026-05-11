<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    private array $adminRoles = ['admin', 'organizador'];

    public function showLoginForm()
    {
        $user = Auth::user();
        if ($user && $this->isAdminRole($user->rol)) {
            $destino = $this->obtenerDestino($user->rol);
            return redirect()->intended($destino);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            ]);

            if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors(['email' => 'Credenciales incorrectas.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$this->isAdminRole($user?->rol)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'No autorizado para acceder al panel.'])
                ->withInput($request->only('email'));
        }
        $destino = $this->obtenerDestino($user->rol);
        return redirect()->intended($destino);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function isAdminRole(?string $role): bool
    {
        return in_array($role, $this->adminRoles, true);
    }

    private function obtenerDestino($rol)
    {
        $destino = match ($rol) {
            'admin' => '/admin/lugares',
            'organizador' => '/organizador/lugares',
            default => '/lugares',
        };
        return $destino;
    }
}
