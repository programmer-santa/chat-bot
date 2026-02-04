@extends('layouts.app')

@section('title', 'Detalles del Servicio')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-list-ul"></i> Detalles del Servicio</h2>
        <a href="{{ route('admin.servicios.index') }}" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Servicio</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $servicio->nombre }}</p>
                <p><strong>Descripción:</strong> {{ $servicio->descripcion ?? 'N/A' }}</p>
                <p><strong>Duración:</strong> {{ $servicio->duracion }} minutos</p>
                <p><strong>Precio:</strong> ${{ number_format($servicio->precio, 2) }}</p>
                <p><strong>Estado:</strong> 
                    @if($servicio->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.servicios.edit', $servicio) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Turnos con este Servicio ({{ $servicio->turnos->count() }})</h5>
            </div>
            <div class="card-body">
                @if($servicio->turnos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Barbero</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicio->turnos as $turno)
                                    <tr>
                                        <td>{{ $turno->user->name }}</td>
                                        <td>{{ $turno->barbero->nombre }}</td>
                                        <td>{{ $turno->fecha->format('d/m/Y') }}</td>
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
                    <p class="text-muted">No hay turnos con este servicio</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
