<?php

namespace App\Http\Controllers;

use App\Models\Barbero;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador del Panel Administrador
 * 
 * Maneja el dashboard y estadísticas del administrador
 */
class AdminController extends Controller
{
    /**
     * Constructor: Aplicar middleware de autenticación y admin
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Mostrar el dashboard del administrador
     */
    public function dashboard()
    {
        // Estadísticas generales
        $stats = [
            'total_barberos' => Barbero::count(),
            'barberos_activos' => Barbero::where('activo', true)->count(),
            'total_servicios' => Servicio::count(),
            'servicios_activos' => Servicio::where('activo', true)->count(),
            'total_turnos' => Turno::count(),
            'turnos_pendientes' => Turno::where('estado', 'pendiente')->count(),
            'turnos_aceptados' => Turno::where('estado', 'aceptado')->count(),
            'turnos_rechazados' => Turno::where('estado', 'rechazado')->count(),
        ];

        // Turnos recientes
        $turnos_recientes = Turno::with(['user', 'barbero', 'servicio'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'turnos_recientes'));
    }
}
