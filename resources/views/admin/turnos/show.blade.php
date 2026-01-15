@extends('layouts.app')

@section('title', 'Detalles del Turno')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-calendar-check"></i> Detalles del Turno</h2>
        <a href="{{ route('admin.turnos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Turno</h5>
            </div>
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $turno->user->name }}</p>
                <p><strong>Email:</strong> {{ $turno->user->email }}</p>
                <p><strong>Barbero:</strong> {{ $turno->barbero->nombre }}</p>
                <p><strong>Servicio:</strong> {{ $turno->servicio->nombre }}</p>
                <p><strong>Precio:</strong> ${{ number_format($turno->servicio->precio, 2) }}</p>
                <p><strong>Duración:</strong> {{ $turno->servicio->duracion }} minutos</p>
                <p><strong>Fecha:</strong> {{ $turno->fecha->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ $turno->hora }}</p>
                <p><strong>Estado:</strong> 
                    @if($turno->estado === 'pendiente')
                        <span class="badge bg-warning">Pendiente</span>
                    @elseif($turno->estado === 'aceptado')
                        <span class="badge bg-success">Aceptado</span>
                    @else
                        <span class="badge bg-danger">Rechazado</span>
                    @endif
                </p>
                @if($turno->observaciones)
                    <p><strong>Observaciones:</strong> {{ $turno->observaciones }}</p>
                @endif
            </div>
            <div class="card-footer">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.turnos.edit', $turno) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                @endif
                @if($turno->estado === 'pendiente')
                    <form action="{{ route('admin.turnos.cambiar-estado', $turno) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        <input type="hidden" name="estado" value="aceptado">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Aceptar
                        </button>
                    </form>
                    <form action="{{ route('admin.turnos.cambiar-estado', $turno) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        <input type="hidden" name="estado" value="rechazado">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Rechazar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
