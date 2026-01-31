<?php

namespace App\Http\Controllers;

use App\Models\Barbero;
use App\Models\Servicio;
use App\Models\Turno;

/**
 * Controlador de Cliente
 * 
 * Maneja la página pública para clientes
 */
class ClienteController extends Controller
{
    /**
     * Mostrar página de inicio pública
     * 
     * Muestra barberos, servicios y turnos disponibles
     */
    public function home()
    {
        // Obtener barberos activos
        $barberos = Barbero::where('activo', true)
            ->with('user')
            ->get();

        // Obtener servicios activos
        $servicios = Servicio::where('activo', true)
            ->orderBy('precio', 'asc')
            ->get();

        // Obtener turnos pendientes (interpretados como "disponibles")
        $turnosDisponibles = Turno::where('estado', 'pendiente')
            ->with(['barbero', 'servicio'])
            ->whereDate('fecha', '>=', now())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->take(10)
            ->get();

        return view('cliente.home', compact('barberos', 'servicios', 'turnosDisponibles'));
    }
}
