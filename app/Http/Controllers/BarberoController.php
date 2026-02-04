<?php

namespace App\Http\Controllers;

use App\Models\Barbero;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Controlador de Barberos
 * 
 * Maneja el CRUD de barberos (solo admin)
 */
class BarberoController extends Controller
{
    /**
     * Constructor: Aplicar middleware de autenticación y admin
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Mostrar lista de barberos
     */
    public function index()
    {
        $barberos = Barbero::with('user')->latest()->get();
        return view('admin.barberos.index', compact('barberos'));
    }

    /**
     * Mostrar formulario para crear barbero
     */
    public function create()
    {
        return view('admin.barberos.create');
    }

    /**
     * Guardar nuevo barbero
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'in:0,1'],
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'barbero',
        ]);

        // Crear perfil de barbero
        $barbero = Barbero::create([
            'user_id' => $user->id,
            'nombre' => $validated['nombre'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
            'activo' => isset($validated['activo']) ? (bool) $validated['activo'] : true,
        ]);

        return redirect()->route('admin.barberos.index')
            ->with('success', 'Barbero creado exitosamente');
    }

    /**
     * Mostrar detalles de un barbero
     */
    public function show(Barbero $barbero)
    {
        $barbero->load([
            'user',
            'turnos' => function($query) {
                $query->with(['user', 'servicio'])->latest();
            }
        ]);
        return view('admin.barberos.show', compact('barbero'));
    }

    /**
     * Mostrar formulario para editar barbero
     */
    public function edit(Barbero $barbero)
    {
        $barbero->load('user');
        return view('admin.barberos.edit', compact('barbero'));
    }

    /**
     * Actualizar barbero
     */
    public function update(Request $request, Barbero $barbero)
    {
        // Validación
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($barbero->user_id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'in:0,1'],
        ]);

        // Actualizar usuario
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $barbero->user->update($userData);

        // Actualizar perfil de barbero
        $barbero->update([
            'nombre' => $validated['nombre'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
            'activo' => isset($validated['activo']) ? (bool) $validated['activo'] : true,
        ]);

        return redirect()->route('admin.barberos.index')
            ->with('success', 'Barbero actualizado exitosamente');
    }

    /**
     * Eliminar barbero
     */
    public function destroy(Barbero $barbero)
    {
        // Eliminar usuario (esto eliminará el barbero por cascade)
        $barbero->user->delete();

        return redirect()->route('admin.barberos.index')
            ->with('success', 'Barbero eliminado exitosamente');
    }
}
