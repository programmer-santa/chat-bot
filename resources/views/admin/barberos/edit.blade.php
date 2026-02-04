@extends('layouts.app')

@section('title', 'Editar Barbero')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-pencil"></i> Editar Barbero</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.barberos.update', $barbero) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="mb-3">Datos de Usuario</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre Completo *</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $barbero->user->name) }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $barbero->user->email) }}" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Nueva Contraseña (dejar vacío para mantener la actual)</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation">
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Datos del Barbero</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre Profesional *</label>
                    <input type="text" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre', $barbero->nombre) }}" 
                           required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">
                        <i class="bi bi-whatsapp text-success"></i> Teléfono / WhatsApp
                    </label>
                    <input type="text" 
                           class="form-control @error('telefono') is-invalid @enderror" 
                           id="telefono" 
                           name="telefono" 
                           value="{{ old('telefono', $barbero->telefono) }}"
                           placeholder="+57 300 123 4567 o 573001234567">
                    <small class="form-text text-muted">
                        <i class="bi bi-info-circle"></i> 
                        Incluye el código de país para WhatsApp (ej: +57 para Colombia). 
                        Formatos válidos: <code>+57 300 123 4567</code>, <code>573001234567</code> o <code>300 123 4567</code>
                    </small>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input type="text" 
                           class="form-control @error('especialidad') is-invalid @enderror" 
                           id="especialidad" 
                           name="especialidad" 
                           value="{{ old('especialidad', $barbero->especialidad) }}">
                    @error('especialidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="activo" class="form-label">Estado</label>
                    <select class="form-select @error('activo') is-invalid @enderror" 
                            id="activo" 
                            name="activo">
                        <option value="1" {{ old('activo', $barbero->activo) ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('activo', $barbero->activo) === false ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('activo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.barberos.index') }}" class="btn-volver">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
