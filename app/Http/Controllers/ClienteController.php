<?php

namespace App\Http\Controllers;

use App\Models\Barbero;
use App\Models\Servicio;
use App\Models\Turno;
use Illuminate\Http\Request;

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

    /**
     * Guardar solicitud de turno desde cliente público
     * 
     * Guarda turno con user_id = null y estado = 'pendiente'
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre_cliente' => ['required', 'string', 'max:255'],
            'barbero_id' => ['required', 'exists:barberos,id'],
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required'],
        ]);

        // Verificar disponibilidad del barbero
        $existeTurno = Turno::where('barbero_id', $validated['barbero_id'])
            ->where('fecha', $validated['fecha'])
            ->where('hora', $validated['hora'])
            ->where('estado', '!=', 'rechazado')
            ->exists();

        if ($existeTurno) {
            return back()
                ->withInput()
                ->with('error', 'El barbero ya tiene un turno en esa fecha y hora. Por favor, selecciona otra fecha u hora.');
        }

        // Preparar observaciones con el nombre del cliente
        $observaciones = 'Cliente: ' . $validated['nombre_cliente'];

        // Guardar turno con user_id = null
        Turno::create([
            'user_id' => null,
            'barbero_id' => $validated['barbero_id'],
            'servicio_id' => $validated['servicio_id'],
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
            'estado' => 'pendiente',
            'observaciones' => $observaciones,
        ]);

        return redirect()->route('cliente.home')
            ->with('success', '¡Solicitud de turno enviada exitosamente! Te contactaremos pronto para confirmar.');
    }
}
