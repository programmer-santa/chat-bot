@extends('layouts.app')

@section('title', 'Panel Barbero')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Panel Barbero</h2>
        <p class="text-muted">Bienvenido, {{ auth()->user()->name }}</p>
    </div>
</div>

@if($barbero)
    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Turnos</h5>
                    <h3>{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pendientes</h5>
                    <h3>{{ $stats['pendientes'] }}</h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Aceptados</h5>
                    <h3>{{ $stats['aceptados'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Turnos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Mis Turnos</h5>
                </div>
                <div class="card-body">
                    @if($turnos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Servicio</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($turnos as $turno)
                                        <tr>
                                            <td>
                                                @if($turno->user)
                                                    {{ $turno->user->name }}
                                                @else
                                                    @php
                                                        // Extraer nombre del cliente desde observaciones
                                                        $observaciones = $turno->observaciones ?? '';
                                                        $nombreCliente = 'Cliente público';
                                                        if (strpos($observaciones, 'Cliente: ') === 0) {
                                                            $lineas = explode("\n", $observaciones);
                                                            $nombreCliente = str_replace('Cliente: ', '', $lineas[0]);
                                                        }
                                                    @endphp
                                                    {{ $nombreCliente }}
                                                @endif
                                            </td>
                                            <td>{{ $turno->servicio->nombre }}</td>
                                            <td>{{ $turno->fecha->format('d/m/Y') }}</td>
                                            <td>{{ $turno->hora }}</td>
                                            <td>
                                                @if($turno->estado === 'pendiente')
                                                    <span class="badge bg-warning">Pendiente</span>
                                                @elseif($turno->estado === 'aceptado')
                                                    <span class="badge bg-success">Aceptado</span>
                                                @else
                                                    <span class="badge bg-danger">Rechazado</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($turno->estado === 'pendiente')
                                                    <div class="btn-group" role="group">
                                                        <form action="{{ route('barbero.turnos.aceptar', $turno->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-success" 
                                                                    title="Aceptar turno">
                                                                <i class="bi bi-check-circle"></i> Aceptar
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('barbero.turnos.rechazar', $turno->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-danger" 
                                                                    title="Rechazar turno"
                                                                    onclick="return confirm('¿Estás seguro de rechazar este turno?');">
                                                                <i class="bi bi-x-circle"></i> Rechazar
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    @php
                                                        // Extraer teléfono del cliente desde observaciones
                                                        $telefonoCliente = null;
                                                        $nombreCliente = 'Cliente';
                                                        
                                                        if ($turno->user) {
                                                            $nombreCliente = $turno->user->name;
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
                                                        
                                                        // Construir mensaje según el estado
                                                        if ($turno->estado === 'aceptado') {
                                                            $mensaje = "Hola " . $nombreCliente . ", confirmo tu turno:\n\n";
                                                            $mensaje .= "✅ Turno ACEPTADO\n\n";
                                                            $mensaje .= "📅 Fecha: " . $turno->fecha->format('d/m/Y') . "\n";
                                                            $mensaje .= "🕐 Hora: " . $turno->hora . "\n";
                                                            $mensaje .= "✂️ Servicio: " . $turno->servicio->nombre . "\n";
                                                            $mensaje .= "💇 Barbero: " . $barbero->nombre . "\n\n";
                                                            $mensaje .= "¡Te esperamos!";
                                                        } else {
                                                            $mensaje = "Hola " . $nombreCliente . ", lamento informarte que:\n\n";
                                                            $mensaje .= "❌ Tu turno ha sido RECHAZADO\n\n";
                                                            $mensaje .= "📅 Fecha solicitada: " . $turno->fecha->format('d/m/Y') . "\n";
                                                            $mensaje .= "🕐 Hora solicitada: " . $turno->hora . "\n";
                                                            $mensaje .= "✂️ Servicio: " . $turno->servicio->nombre . "\n\n";
                                                            $mensaje .= "Por favor, contáctame para proponerte otra fecha y hora disponible.";
                                                        }
                                                        
                                                        // URL de WhatsApp (solo si hay teléfono disponible)
                                                        $whatsappUrl = null;
                                                        if ($telefonoCliente && !empty($telefonoCliente)) {
                                                            $whatsappUrl = "https://wa.me/" . $telefonoCliente . "?text=" . urlencode($mensaje);
                                                        }
                                                    @endphp
                                                    
                                                    @if($whatsappUrl)
                                                        <a href="{{ $whatsappUrl }}" 
                                                           class="btn btn-sm btn-success" 
                                                           target="_blank"
                                                           title="Contactar cliente por WhatsApp">
                                                            <i class="bi bi-whatsapp"></i> Contactar por WhatsApp
                                                        </a>
                                                    @else
                                                        <span class="text-muted small" title="Cliente no tiene teléfono registrado">
                                                            <i class="bi bi-exclamation-circle"></i> Sin teléfono
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No tienes turnos asignados</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i> 
        No tienes un perfil de barbero asociado. Contacta al administrador.
    </div>
@endif
@endsection
