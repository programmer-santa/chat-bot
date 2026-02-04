@extends('layouts.app')

@section('title', 'Gestión de Turnos')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn-volver">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <div>
                <h2 class="mb-0"><i class="bi bi-calendar-check"></i> Listado de Turnos</h2>
                <p class="text-muted mb-0">Visualización de todos los turnos del sistema</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($turnos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Barbero</th>
                            <th>Servicio</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($turnos as $turno)
                            <tr>
                                <td>{{ $turno->id }}</td>
                                <td>
                                    @if($turno->user)
                                        {{ $turno->user->name }}
                                    @else
                                        {{ Str::after($turno->observaciones ?? '', 'Cliente: ') ?: 'Cliente público' }}
                                    @endif
                                </td>
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
            <p class="text-muted text-center">No hay turnos registrados</p>
        @endif
    </div>
</div>
@endsection
