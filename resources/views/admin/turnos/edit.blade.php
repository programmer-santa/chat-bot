@extends('layouts.app')

@section('title', 'Editar Turno')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-pencil"></i> Editar Turno</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.turnos.update', $turno) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">Cliente</label>
                    <input type="text" 
                           class="form-control" 
                           value="{{ $turno->user->name }} ({{ $turno->user->email }})" 
                           disabled>
                    <small class="text-muted">No se puede cambiar el cliente</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="barbero_id" class="form-label">Barbero *</label>
                    <select class="form-select @error('barbero_id') is-invalid @enderror" 
                            id="barbero_id" 
                            name="barbero_id" 
                            required>
                        <option value="">Seleccione un barbero</option>
                        @foreach($barberos as $barbero)
                            <option value="{{ $barbero->id }}" 
                                    {{ old('barbero_id', $turno->barbero_id) == $barbero->id ? 'selected' : '' }}>
                                {{ $barbero->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('barbero_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="servicio_id" class="form-label">Servicio *</label>
                    <select class="form-select @error('servicio_id') is-invalid @enderror" 
                            id="servicio_id" 
                            name="servicio_id" 
                            required>
                        <option value="">Seleccione un servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" 
                                    {{ old('servicio_id', $turno->servicio_id) == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('servicio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado *</label>
                    <select class="form-select @error('estado') is-invalid @enderror" 
                            id="estado" 
                            name="estado" 
                            required>
                        <option value="pendiente" {{ old('estado', $turno->estado) === 'pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="aceptado" {{ old('estado', $turno->estado) === 'aceptado' ? 'selected' : '' }}>
                            Aceptado
                        </option>
                        <option value="rechazado" {{ old('estado', $turno->estado) === 'rechazado' ? 'selected' : '' }}>
                            Rechazado
                        </option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha *</label>
                    <input type="date" 
                           class="form-control @error('fecha') is-invalid @enderror" 
                           id="fecha" 
                           name="fecha" 
                           value="{{ old('fecha', $turno->fecha->format('Y-m-d')) }}" 
                           required>
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="hora" class="form-label">Hora *</label>
                    <input type="time" 
                           class="form-control @error('hora') is-invalid @enderror" 
                           id="hora" 
                           name="hora" 
                           value="{{ old('hora', $turno->hora) }}" 
                           required>
                    @error('hora')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                              id="observaciones" 
                              name="observaciones" 
                              rows="3">{{ old('observaciones', $turno->observaciones) }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.turnos.index') }}" class="btn-volver">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="bi bi-check"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
