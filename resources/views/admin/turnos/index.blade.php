@extends('layouts.app')

@section('title', 'Gestión de Turnos')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-calendar-check"></i> Gestión de Turnos</h2>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.turnos.create') }}" class="btn btn-info">
                <i class="bi bi-calendar-plus"></i> Nuevo Turno
            </a>
        @endif
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($turnos as $turno)
                            <tr>
                                <td>{{ $turno->id }}</td>
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
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.turnos.show', $turno) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.turnos.edit', $turno) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        @if($turno->estado === 'pendiente')
                                            <form action="{{ route('admin.turnos.cambiar-estado', $turno) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="estado" value="aceptado">
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Aceptar">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.turnos.cambiar-estado', $turno) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="estado" value="rechazado">
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Rechazar">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('admin.turnos.destroy', $turno) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este turno?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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
