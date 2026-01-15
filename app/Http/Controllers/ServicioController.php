<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

/**
 * Controlador de Servicios
 * 
 * Maneja el CRUD de servicios (solo admin)
 */
class ServicioController extends Controller
{
    /**
     * Constructor: Aplicar middleware de autenticación y admin
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Mostrar lista de servicios
     */
    public function index()
    {
        $servicios = Servicio::latest()->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    /**
     * Mostrar formulario para crear servicio
     */
    public function create()
    {
        return view('admin.servicios.create');
    }

    /**
     * Guardar nuevo servicio
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'duracion' => ['required', 'integer', 'min:1'],
            'precio' => ['required', 'numeric', 'min:0'],
            'activo' => ['boolean'],
        ]);

        Servicio::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'duracion' => $validated['duracion'],
            'precio' => $validated['precio'],
            'activo' => $validated['activo'] ?? true,
        ]);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio creado exitosamente');
    }

    /**
     * Mostrar detalles de un servicio
     */
    public function show(Servicio $servicio)
    {
        $servicio->load('turnos');
        return view('admin.servicios.show', compact('servicio'));
    }

    /**
     * Mostrar formulario para editar servicio
     */
    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', compact('servicio'));
    }

    /**
     * Actualizar servicio
     */
    public function update(Request $request, Servicio $servicio)
    {
        // Validación
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'duracion' => ['required', 'integer', 'min:1'],
            'precio' => ['required', 'numeric', 'min:0'],
            'activo' => ['boolean'],
        ]);

        $servicio->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'duracion' => $validated['duracion'],
            'precio' => $validated['precio'],
            'activo' => $validated['activo'] ?? true,
        ]);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado exitosamente');
    }

    /**
     * Eliminar servicio
     */
    public function destroy(Servicio $servicio)
    {
        // Verificar si tiene turnos asociados
        if ($servicio->turnos()->count() > 0) {
            return redirect()->route('admin.servicios.index')
                ->with('error', 'No se puede eliminar el servicio porque tiene turnos asociados');
        }

        $servicio->delete();

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio eliminado exitosamente');
    }
}
