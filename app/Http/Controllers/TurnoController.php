<?php

namespace App\Http\Controllers;

use App\Models\Barbero;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador de Turnos
 * 
 * Maneja la gestión de turnos (admin y barbero)
 */
class TurnoController extends Controller
{
    /**
     * Constructor: Aplicar middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Mostrar lista de turnos
     * Para admin: muestra todos los turnos
     * Para barbero: muestra solo sus turnos
     */
    public function index()
    {
        $user = auth()->user();

        // Si es admin, mostrar todos los turnos
        if ($user->isAdmin()) {
            $turnos = Turno::with(['user', 'barbero', 'servicio'])
                ->latest()
                ->get();
        } else {
            // Barbero ve solo sus turnos
            $barbero = $user->barbero;
            if ($barbero) {
                $turnos = Turno::with(['user', 'barbero', 'servicio'])
                    ->where('barbero_id', $barbero->id)
                    ->latest()
                    ->get();
            } else {
                $turnos = collect();
            }
        }

        return view('admin.turnos.index', compact('turnos'));
    }

    /**
     * Mostrar formulario para crear turno
     */
    public function create()
    {
        $users = User::all();
        $barberos = Barbero::where('activo', true)->get();
        $servicios = Servicio::where('activo', true)->get();

        return view('admin.turnos.create', compact('users', 'barberos', 'servicios'));
    }

    /**
     * Guardar nuevo turno
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'barbero_id' => ['required', 'exists:barberos,id'],
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required'],
            'observaciones' => ['nullable', 'string'],
        ]);

        // Verificar disponibilidad del barbero (opcional, se puede mejorar)
        $existeTurno = Turno::where('barbero_id', $validated['barbero_id'])
            ->where('fecha', $validated['fecha'])
            ->where('hora', $validated['hora'])
            ->where('estado', '!=', 'rechazado')
            ->exists();

        if ($existeTurno) {
            return back()
                ->withInput()
                ->with('error', 'El barbero ya tiene un turno en esa fecha y hora');
        }

        Turno::create([
            'user_id' => $validated['user_id'],
            'barbero_id' => $validated['barbero_id'],
            'servicio_id' => $validated['servicio_id'],
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
            'estado' => 'pendiente',
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        return redirect()->route('admin.turnos.index')
            ->with('success', 'Turno creado exitosamente');
    }

    /**
     * Mostrar detalles de un turno
     */
    public function show(Turno $turno)
    {
        $turno->load(['user', 'barbero', 'servicio']);
        return view('admin.turnos.show', compact('turno'));
    }

    /**
     * Mostrar formulario para editar turno
     */
    public function edit(Turno $turno)
    {
        $barberos = Barbero::where('activo', true)->get();
        $servicios = Servicio::where('activo', true)->get();
        $turno->load(['user', 'barbero', 'servicio']);

        return view('admin.turnos.edit', compact('turno', 'barberos', 'servicios'));
    }

    /**
     * Actualizar turno
     */
    public function update(Request $request, Turno $turno)
    {
        // Validación
        $validated = $request->validate([
            'barbero_id' => ['required', 'exists:barberos,id'],
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha' => ['required', 'date'],
            'hora' => ['required'],
            'estado' => ['required', 'in:pendiente,aceptado,rechazado'],
            'observaciones' => ['nullable', 'string'],
        ]);

        // Verificar disponibilidad del barbero (excepto el turno actual)
        $existeTurno = Turno::where('barbero_id', $validated['barbero_id'])
            ->where('fecha', $validated['fecha'])
            ->where('hora', $validated['hora'])
            ->where('id', '!=', $turno->id)
            ->where('estado', '!=', 'rechazado')
            ->exists();

        if ($existeTurno) {
            return back()
                ->withInput()
                ->with('error', 'El barbero ya tiene un turno en esa fecha y hora');
        }

        $turno->update($validated);

        return redirect()->route('admin.turnos.index')
            ->with('success', 'Turno actualizado exitosamente');
    }

    /**
     * Eliminar turno
     */
    public function destroy(Turno $turno)
    {
        $turno->delete();

        return redirect()->route('admin.turnos.index')
            ->with('success', 'Turno eliminado exitosamente');
    }

    /**
     * Cambiar estado del turno (aceptar/rechazar)
     */
    public function cambiarEstado(Request $request, Turno $turno)
    {
        $validated = $request->validate([
            'estado' => ['required', 'in:aceptado,rechazado'],
        ]);

        $turno->update(['estado' => $validated['estado']]);

        $mensaje = $validated['estado'] === 'aceptado' 
            ? 'Turno aceptado exitosamente' 
            : 'Turno rechazado exitosamente';

        return redirect()->route('admin.turnos.index')
            ->with('success', $mensaje);
    }
}
