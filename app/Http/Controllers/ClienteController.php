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
            'telefono_cliente' => ['nullable', 'string', 'max:20'],
        ]);

        // Verificar disponibilidad del horario
        // No permitir crear turno si ya existe uno con mismo barbero, fecha, hora y estado pendiente o aceptado
        $existeTurno = Turno::where('barbero_id', $validated['barbero_id'])
            ->where('fecha', $validated['fecha'])
            ->where('hora', $validated['hora'])
            ->whereIn('estado', ['pendiente', 'aceptado'])
            ->exists();

        if ($existeTurno) {
            return back()
                ->withInput()
                ->with('error', 'El horario seleccionado no está disponible. Por favor elige otro.');
        }

        // Preparar observaciones con el nombre y teléfono del cliente
        $observaciones = 'Cliente: ' . $validated['nombre_cliente'];
        if (!empty($validated['telefono_cliente'])) {
            $observaciones .= "\nTeléfono: " . $validated['telefono_cliente'];
        }

        // Obtener información del barbero y servicio para el mensaje de WhatsApp
        $barbero = Barbero::findOrFail($validated['barbero_id']);
        $servicio = Servicio::findOrFail($validated['servicio_id']);

        // Guardar turno con user_id = null
        $turno = Turno::create([
            'user_id' => null,
            'barbero_id' => $validated['barbero_id'],
            'servicio_id' => $validated['servicio_id'],
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
            'estado' => 'pendiente',
            'observaciones' => $observaciones,
        ]);

        // Guardar información del turno en sesión para mostrar botón de WhatsApp
        $request->session()->put('turno_creado', [
            'nombre_cliente' => $validated['nombre_cliente'],
            'barbero' => $barbero->nombre,
            'barbero_telefono' => $barbero->telefono, // Teléfono del barbero para WhatsApp
            'servicio' => $servicio->nombre,
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
        ]);

        return redirect()->route('cliente.home')
            ->with('success', '¡Solicitud de turno enviada exitosamente! Te contactaremos pronto para confirmar.');
    }
}
