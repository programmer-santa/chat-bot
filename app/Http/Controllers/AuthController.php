<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Controlador de Autenticación
 * 
 * Maneja el login y logout del sistema
 */
class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     * Solo permite acceso a usuarios administradores
     */
    public function login(Request $request)
    {
        // Validación de datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Solo permitir acceso a administradores
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenido, ' . $user->name);
            }

            // Si no es admin, cerrar sesión y denegar acceso
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => ['No tienes permisos para acceder al sistema. Solo administradores.'],
            ]);
        }

        // Si falla la autenticación
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no son correctas.'],
        ]);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
