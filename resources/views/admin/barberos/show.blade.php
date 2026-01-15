@extends('layouts.app')

@section('title', 'Detalles del Barbero')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-person"></i> Detalles del Barbero</h2>
        <a href="{{ route('admin.barberos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Usuario</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $barbero->user->name }}</p>
                <p><strong>Email:</strong> {{ $barbero->user->email }}</p>
                <p><strong>Rol:</strong> <span class="badge bg-info">{{ $barbero->user->role }}</span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Barbero</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre Profesional:</strong> {{ $barbero->nombre }}</p>
                <p><strong>Teléfono:</strong> {{ $barbero->telefono ?? 'N/A' }}</p>
                <p><strong>Especialidad:</strong> {{ $barbero->especialidad ?? 'N/A' }}</p>
                <p><strong>Estado:</strong> 
                    @if($barbero->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Turnos Asignados ({{ $barbero->turnos->count() }})</h5>
                <a href="{{ route('admin.barberos.edit', $barbero) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
            <div class="card-body">
                @if($barbero->turnos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barbero->turnos as $turno)
                                    <tr>
                                        <td>{{ $turno->user->name }}</td>
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
                    <p class="text-muted">Este barbero no tiene turnos asignados</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
