@extends('layouts.app')

@section('title', 'Editar Servicio')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-pencil"></i> Editar Servicio</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.servicios.update', $servicio) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Servicio *</label>
                    <input type="text" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre', $servicio->nombre) }}" 
                           required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="precio" class="form-label">Precio *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control @error('precio') is-invalid @enderror" 
                               id="precio" 
                               name="precio" 
                               value="{{ old('precio', $servicio->precio) }}" 
                               required>
                        @error('precio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="duracion" class="form-label">Duración (minutos) *</label>
                    <input type="number" 
                           min="1"
                           class="form-control @error('duracion') is-invalid @enderror" 
                           id="duracion" 
                           name="duracion" 
                           value="{{ old('duracion', $servicio->duracion) }}" 
                           required>
                    @error('duracion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="activo" class="form-label">Estado</label>
                    <select class="form-select @error('activo') is-invalid @enderror" 
                            id="activo" 
                            name="activo">
                        <option value="1" {{ old('activo', $servicio->activo) ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('activo', $servicio->activo) === false ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('activo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" 
                              name="descripcion" 
                              rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.servicios.index') }}" class="btn-volver">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
