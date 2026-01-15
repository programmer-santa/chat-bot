@extends('layouts.app')

@section('title', 'Gestión de Barberos')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-people"></i> Gestión de Barberos</h2>
        <a href="{{ route('admin.barberos.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo Barbero
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($barberos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barberos as $barbero)
                            <tr>
                                <td>{{ $barbero->id }}</td>
                                <td>{{ $barbero->nombre }}</td>
                                <td>{{ $barbero->user->email }}</td>
                                <td>{{ $barbero->telefono ?? 'N/A' }}</td>
                                <td>{{ $barbero->especialidad ?? 'N/A' }}</td>
                                <td>
                                    @if($barbero->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.barberos.show', $barbero) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.barberos.edit', $barbero) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.barberos.destroy', $barbero) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este barbero?');">
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
            <p class="text-muted text-center">No hay barberos registrados</p>
        @endif
    </div>
</div>
@endsection
