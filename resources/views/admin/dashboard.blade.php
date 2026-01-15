@extends('layouts.app')

@section('title', 'Panel Administrador')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Panel Administrador</h2>
        <p class="text-muted">Bienvenido, {{ auth()->user()->name }}</p>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-people"></i> Barberos
                </h5>
                <h3>{{ $stats['total_barberos'] }}</h3>
                <small>Activos: {{ $stats['barberos_activos'] }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-list-ul"></i> Servicios
                </h5>
                <h3>{{ $stats['total_servicios'] }}</h3>
                <small>Activos: {{ $stats['servicios_activos'] }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-calendar-check"></i> Turnos
                </h5>
                <h3>{{ $stats['total_turnos'] }}</h3>
                <small>Pendientes: {{ $stats['turnos_pendientes'] }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-pie-chart"></i> Estados
                </h5>
                <p class="mb-0">
                    <small>Aceptados: {{ $stats['turnos_aceptados'] }}</small><br>
                    <small>Rechazados: {{ $stats['turnos_rechazados'] }}</small>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Accesos Rápidos -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.barberos.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-person-plus"></i> Nuevo Barbero
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.servicios.create') }}" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle"></i> Nuevo Servicio
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.turnos.create') }}" class="btn btn-info w-100">
                            <i class="bi bi-calendar-plus"></i> Nuevo Turno
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.turnos.index') }}" class="btn btn-warning w-100">
                            <i class="bi bi-calendar-check"></i> Ver Turnos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Turnos Recientes -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Turnos Recientes</h5>
                <a href="{{ route('admin.turnos.index') }}" class="btn btn-sm btn-outline-primary">
                    Ver Todos
                </a>
            </div>
            <div class="card-body">
                @if($turnos_recientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Barbero</th>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turnos_recientes as $turno)
                                    <tr>
                                        <td>{{ $turno->user->name }}</td>
                                        <td>{{ $turno->barbero->nombre }}</td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No hay turnos recientes</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
