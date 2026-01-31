<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Barbería - Inicio</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('cliente.home') }}">
                <i class="bi bi-scissors"></i> Sistema Barbería
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('turnos.crear') }}">
                    <i class="bi bi-calendar-plus"></i> Agendar Turno
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-3">
                    <i class="bi bi-scissors text-primary"></i> Bienvenido a Nuestra Barbería
                </h1>
                <p class="lead text-muted">Servicios profesionales de barbería con los mejores especialistas</p>
                <a href="{{ route('turnos.crear') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-calendar-plus"></i> Agendar Turno Ahora
                </a>
            </div>
        </div>

        <!-- Barberos -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="bi bi-people"></i> Nuestros Barberos
                </h2>
                <div class="row">
                    @forelse($barberos as $barbero)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-person-badge"></i> {{ $barbero->nombre }}
                                    </h5>
                                    @if($barbero->especialidad)
                                        <p class="card-text text-muted">
                                            <i class="bi bi-star"></i> {{ $barbero->especialidad }}
                                        </p>
                                    @endif
                                    @if($barbero->telefono)
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <i class="bi bi-telephone"></i> {{ $barbero->telefono }}
                                            </small>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No hay barberos disponibles en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Servicios -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="bi bi-list-check"></i> Nuestros Servicios
                </h2>
                <div class="row">
                    @forelse($servicios as $servicio)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="card-title">{{ $servicio->nombre }}</h5>
                                            @if($servicio->descripcion)
                                                <p class="card-text text-muted">{{ $servicio->descripcion }}</p>
                                            @endif
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="bi bi-clock"></i> {{ $servicio->duracion }} minutos
                                                </small>
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <h4 class="text-primary mb-0">${{ number_format($servicio->precio, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No hay servicios disponibles en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Turnos Disponibles -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="bi bi-calendar-check"></i> Turnos Disponibles
                </h2>
                @if($turnosDisponibles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Barbero</th>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turnosDisponibles as $turno)
                                    <tr>
                                        <td>{{ $turno->barbero->nombre }}</td>
                                        <td>{{ $turno->servicio->nombre }}</td>
                                        <td>{{ $turno->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $turno->hora }}</td>
                                        <td>
                                            @php
                                                // Número de WhatsApp (configurar según necesidad)
                                                $whatsappNumber = '1234567890'; // Cambiar por el número real
                                                $mensaje = "Hola, me interesa el turno del " . $turno->fecha->format('d/m/Y') . " a las " . $turno->hora . " con " . $turno->barbero->nombre . " - Servicio: " . $turno->servicio->nombre;
                                                $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($mensaje);
                                            @endphp
                                            <a href="{{ $whatsappUrl }}" 
                                               class="btn btn-sm btn-success" 
                                               target="_blank">
                                                <i class="bi bi-whatsapp"></i> Reservar por WhatsApp
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        No hay turnos disponibles en este momento. 
                        <a href="{{ route('turnos.crear') }}" class="alert-link">Agenda tu turno aquí</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Formulario de Solicitud de Turno -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="bi bi-calendar-plus"></i> Solicitar Turno
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            
                            @if(session('turno_creado'))
                                @php
                                    $turno = session('turno_creado');
                                    // Número de WhatsApp de la barbería (configurar según necesidad)
                                    $whatsappNumber = '1234567890'; // Cambiar por el número real (formato: código país + número sin espacios ni guiones)
                                    
                                    // Construir mensaje
                                    $mensaje = "Hola, solicité un turno con la siguiente información:\n\n";
                                    $mensaje .= "👤 Cliente: " . $turno['nombre_cliente'] . "\n";
                                    $mensaje .= "💇 Barbero: " . $turno['barbero'] . "\n";
                                    $mensaje .= "✂️ Servicio: " . $turno['servicio'] . "\n";
                                    $mensaje .= "📅 Fecha: " . date('d/m/Y', strtotime($turno['fecha'])) . "\n";
                                    $mensaje .= "🕐 Hora: " . $turno['hora'] . "\n\n";
                                    $mensaje .= "Por favor, confírmame si está disponible.";
                                    
                                    // URL de WhatsApp
                                    $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($mensaje);
                                @endphp
                                
                                <div class="alert alert-info mt-3">
                                    <h5 class="alert-heading">
                                        <i class="bi bi-whatsapp"></i> ¿Deseas enviar la información por WhatsApp?
                                    </h5>
                                    <p class="mb-3">Puedes enviar los detalles de tu turno directamente a la barbería:</p>
                                    <div class="mb-2">
                                        <strong>Cliente:</strong> {{ $turno['nombre_cliente'] }}<br>
                                        <strong>Barbero:</strong> {{ $turno['barbero'] }}<br>
                                        <strong>Servicio:</strong> {{ $turno['servicio'] }}<br>
                                        <strong>Fecha:</strong> {{ date('d/m/Y', strtotime($turno['fecha'])) }}<br>
                                        <strong>Hora:</strong> {{ $turno['hora'] }}
                                    </div>
                                    <a href="{{ $whatsappUrl }}" 
                                       class="btn btn-success btn-lg" 
                                       target="_blank">
                                        <i class="bi bi-whatsapp"></i> Enviar por WhatsApp
                                    </a>
                                </div>
                            @endif
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

                        <form action="{{ route('turnos.solicitar') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
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
                            </div>

                            <div class="row">
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
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('servicio_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
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

                                <div class="col-md-3 mb-3">
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

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Solicitar Turno
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">¿Listo para tu próximo corte?</h3>
                        <p class="card-text mb-4">Agenda tu turno ahora y disfruta de nuestros servicios profesionales</p>
                        <a href="{{ route('turnos.crear') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-calendar-plus"></i> Agendar Turno
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Sistema Barbería. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
