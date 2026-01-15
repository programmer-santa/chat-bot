@extends('layouts.app')

@section('title', 'Crear Turno')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-calendar-plus"></i> Crear Nuevo Turno</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.turnos.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">Cliente *</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" 
                            id="user_id" 
                            name="user_id" 
                            required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="barbero_id" class="form-label">Barbero *</label>
                    <select class="form-select @error('barbero_id') is-invalid @enderror" 
                            id="barbero_id" 
                            name="barbero_id" 
                            required>
                        <option value="">Seleccione un barbero</option>
                        @foreach($barberos as $barbero)
                            <option value="{{ $barbero->id }}" {{ old('barbero_id') == $barbero->id ? 'selected' : '' }}>
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
                            <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('servicio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fecha" class="form-label">Fecha *</label>
                    <input type="date" 
                           class="form-control @error('fecha') is-invalid @enderror" 
                           id="fecha" 
                           name="fecha" 
                           value="{{ old('fecha') }}" 
                           min="{{ date('Y-m-d') }}"
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
                           value="{{ old('hora') }}" 
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
                              rows="3">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.turnos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-info">
                    <i class="bi bi-check"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
