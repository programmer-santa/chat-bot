@extends('layouts.app')

@section('title', 'Gestión de Servicios')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn-volver">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <h2 class="mb-0"><i class="bi bi-list-ul"></i> Gestión de Servicios</h2>
        </div>
        <a href="{{ route('admin.servicios.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nuevo Servicio
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($servicios->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicios as $servicio)
                            <tr>
                                <td>{{ $servicio->id }}</td>
                                <td>{{ $servicio->nombre }}</td>
                                <td>{{ Str::limit($servicio->descripcion, 50) ?? 'N/A' }}</td>
                                <td>{{ $servicio->duracion }} min</td>
                                <td>${{ number_format($servicio->precio, 2) }}</td>
                                <td>
                                    @if($servicio->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.servicios.show', $servicio) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.servicios.edit', $servicio) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.servicios.destroy', $servicio) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este servicio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center">No hay servicios registrados</p>
        @endif
    </div>
</div>
@endsection
