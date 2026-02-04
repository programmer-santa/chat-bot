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

        // Preparar información para WhatsApp
        $whatsappData = $this->prepararWhatsApp($turno, 'aceptado');
        
        return redirect()->route('barbero.dashboard')
            ->with('success', 'Turno aceptado exitosamente.')
            ->with('turno_whatsapp', $whatsappData);
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

        // Preparar información para WhatsApp
        $whatsappData = $this->prepararWhatsApp($turno, 'rechazado');
        
        return redirect()->route('barbero.dashboard')
            ->with('success', 'Turno rechazado exitosamente.')
            ->with('turno_whatsapp', $whatsappData);
    }

    /**
     * Preparar datos de WhatsApp para el cliente
     */
    private function prepararWhatsApp(Turno $turno, string $estado): ?array
    {
        // Cargar relaciones necesarias
        $turno->load(['servicio', 'user']);
        
        // Extraer teléfono del cliente
        $telefonoCliente = null;
        $nombreCliente = 'Cliente';
        
        if ($turno->user) {
            $nombreCliente = $turno->user->name;
            // Si el usuario tiene teléfono en algún campo, extraerlo
            // Por ahora, solo usamos observaciones para clientes públicos
        } else {
            // Extraer nombre y teléfono desde observaciones
            $observaciones = $turno->observaciones ?? '';
            if (strpos($observaciones, 'Cliente: ') === 0) {
                $lineas = explode("\n", $observaciones);
                $nombreCliente = str_replace('Cliente: ', '', $lineas[0]);
                
                // Buscar teléfono en observaciones
                foreach ($lineas as $linea) {
                    if (strpos($linea, 'Teléfono: ') !== false) {
                        $telefonoCliente = trim(str_replace('Teléfono: ', '', $linea));
                        break;
                    }
                }
            }
        }
        
        // Limpiar y normalizar el número para WhatsApp
        if ($telefonoCliente) {
            $telefonoCliente = preg_replace('/[^0-9]/', '', $telefonoCliente);
            // Si el número no empieza con código de país (57 para Colombia), agregarlo
            if (strlen($telefonoCliente) == 10 && substr($telefonoCliente, 0, 1) == '3') {
                $telefonoCliente = '57' . $telefonoCliente;
            }
        }
        
        // Si no hay teléfono, retornar null
        if (!$telefonoCliente || empty($telefonoCliente)) {
            return null;
        }
        
        // Construir mensaje según el estado (formato original mejorado)
        $barbero = auth()->user()->barbero;
        if ($estado === 'aceptado') {
            $mensaje = "Hola " . $nombreCliente . ", confirmo tu turno:\n\n";
            $mensaje .= "✅ Turno ACEPTADO\n\n";
            $mensaje .= "📅 Fecha: " . $turno->fecha->format('d/m/Y') . "\n";
            $mensaje .= "🕐 Hora: " . $turno->hora . "\n";
            $mensaje .= "✂️ Servicio: " . $turno->servicio->nombre . "\n";
            if ($barbero) {
                $mensaje .= "💇 Barbero: " . $barbero->nombre . "\n\n";
            }
            $mensaje .= "¡Te esperamos!";
        } else {
            $mensaje = "Hola " . $nombreCliente . ", lamento informarte que:\n\n";
            $mensaje .= "❌ Tu turno ha sido RECHAZADO\n\n";
            $mensaje .= "📅 Fecha solicitada: " . $turno->fecha->format('d/m/Y') . "\n";
            $mensaje .= "🕐 Hora solicitada: " . $turno->hora . "\n";
            $mensaje .= "✂️ Servicio: " . $turno->servicio->nombre . "\n\n";
            $mensaje .= "Por favor, contáctame para proponerte otra fecha y hora disponible.";
        }
        
        // Crear URL de WhatsApp
        $whatsappUrl = "https://wa.me/" . $telefonoCliente . "?text=" . urlencode($mensaje);
        
        return [
            'url' => $whatsappUrl,
            'telefono' => $telefonoCliente,
            'nombre_cliente' => $nombreCliente,
        ];
    }
}
