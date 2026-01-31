<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;

/**
 * Controlador del Panel Barbero
 * 
 * Maneja el dashboard del barbero con sus turnos
 */
class BarberoPanelController extends Controller
{
    /**
     * Constructor: Aplicar middleware de autenticación y barbero
     */
    public function __construct()
    {
        $this->middleware(['auth', 'barbero']);
    }

    /**
     * Mostrar el dashboard del barbero
     * 
     * Muestra solo los turnos asignados al barbero autenticado
     */
    public function dashboard()
    {
        $user = auth()->user();
        $barbero = $user->barbero;

        // Si no tiene perfil de barbero, retornar vista con mensaje
        if (!$barbero) {
            return view('barbero.dashboard', [
                'barbero' => null,
                'turnos' => collect(),
                'stats' => [
                    'total' => 0,
                    'pendientes' => 0,
                    'aceptados' => 0,
                ]
            ]);
        }

        // Obtener solo los turnos del barbero autenticado
        $turnos = Turno::with(['user', 'servicio'])
            ->where('barbero_id', $barbero->id)
            ->latest()
            ->get();

        // Calcular estadísticas
        $stats = [
            'total' => $turnos->count(),
            'pendientes' => $turnos->where('estado', 'pendiente')->count(),
            'aceptados' => $turnos->where('estado', 'aceptado')->count(),
        ];

        return view('barbero.dashboard', compact('barbero', 'turnos', 'stats'));
    }

    /**
     * Aceptar un turno pendiente
     * 
     * Valida que el turno pertenece al barbero autenticado
     */
    public function aceptar($id)
    {
        $user = auth()->user();
        $barbero = $user->barbero;

        if (!$barbero) {
            return redirect()->route('barbero.dashboard')
                ->with('error', 'No tienes un perfil de barbero asociado.');
        }

        // Buscar el turno y validar que pertenece al barbero
        $turno = Turno::where('id', $id)
            ->where('barbero_id', $barbero->id)
            ->firstOrFail();

        // Validar que el turno esté pendiente
        if ($turno->estado !== 'pendiente') {
            return redirect()->route('barbero.dashboard')
                ->with('error', 'Solo se pueden aceptar turnos pendientes.');
        }

        // Cambiar estado a aceptado
        $turno->update(['estado' => 'aceptado']);

        return redirect()->route('barbero.dashboard')
            ->with('success', 'Turno aceptado exitosamente.');
    }

    /**
     * Rechazar un turno pendiente
     * 
     * Valida que el turno pertenece al barbero autenticado
     */
    public function rechazar($id)
    {
        $user = auth()->user();
        $barbero = $user->barbero;

        if (!$barbero) {
            return redirect()->route('barbero.dashboard')
                ->with('error', 'No tienes un perfil de barbero asociado.');
        }

        // Buscar el turno y validar que pertenece al barbero
        $turno = Turno::where('id', $id)
            ->where('barbero_id', $barbero->id)
            ->firstOrFail();

        // Validar que el turno esté pendiente
        if ($turno->estado !== 'pendiente') {
            return redirect()->route('barbero.dashboard')
                ->with('error', 'Solo se pueden rechazar turnos pendientes.');
        }

        // Cambiar estado a rechazado
        $turno->update(['estado' => 'rechazado']);

        return redirect()->route('barbero.dashboard')
            ->with('success', 'Turno rechazado exitosamente.');
    }
}
