<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agendar Turno - Sistema Barbería</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('turnos.crear') }}">
                <i class="bi bi-scissors"></i> Sistema Barbería
            </a>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="bi bi-calendar-plus"></i> Agendar Turno
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> 
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('turnos.guardar') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nombre_cliente" class="form-label">
                                    <i class="bi bi-person"></i> Nombre del Cliente *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre_cliente') is-invalid @enderror" 
                                       id="nombre_cliente" 
                                       name="nombre_cliente" 
                                       value="{{ old('nombre_cliente') }}" 
                                       required
                                       placeholder="Ingresa tu nombre completo">
                                @error('nombre_cliente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="barbero_id" class="form-label">
                                        <i class="bi bi-person-badge"></i> Seleccionar Barbero *
                                    </label>
                                    <select class="form-select @error('barbero_id') is-invalid @enderror" 
                                            id="barbero_id" 
                                            name="barbero_id" 
                                            required>
                                        <option value="">-- Selecciona un barbero --</option>
                                        @foreach($barberos as $barbero)
                                            <option value="{{ $barbero->id }}" {{ old('barbero_id') == $barbero->id ? 'selected' : '' }}>
                                                {{ $barbero->nombre }}
                                                @if($barbero->especialidad)
                                                    - {{ $barbero->especialidad }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('barbero_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="servicio_id" class="form-label">
                                        <i class="bi bi-list-check"></i> Seleccionar Servicio *
                                    </label>
                                    <select class="form-select @error('servicio_id') is-invalid @enderror" 
                                            id="servicio_id" 
                                            name="servicio_id" 
                                            required>
                                        <option value="">-- Selecciona un servicio --</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                                                ({{ $servicio->duracion }} min)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('servicio_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label">
                                        <i class="bi bi-calendar"></i> Fecha *
                                    </label>
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
                                    <label for="hora" class="form-label">
                                        <i class="bi bi-clock"></i> Hora *
                                    </label>
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
                            </div>

                            <div class="mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="bi bi-chat-left-text"></i> Observaciones (opcional)
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                          id="observaciones" 
                                          name="observaciones" 
                                          rows="3" 
                                          placeholder="Alguna observación o comentario adicional...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Agendar Turno
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
