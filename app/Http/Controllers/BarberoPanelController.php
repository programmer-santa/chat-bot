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
}
