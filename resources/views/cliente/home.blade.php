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
                <a class="nav-link" href="{{ route('login') }}" title="Iniciar sesión como Barbero o Administrador">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
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
                <p class="lead text-muted mb-4">Servicios profesionales de barbería con los mejores especialistas</p>
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center mb-3">
                    <button type="button" 
                            class="btn btn-primary btn-lg px-5 py-3" 
                            onclick="mostrarFormulario()"
                            style="font-size: 1.2rem;">
                        <i class="bi bi-arrow-right-circle"></i> Continuar sin iniciar sesión
                    </button>
                    <a href="{{ route('login') }}" 
                       class="btn btn-outline-secondary btn-lg px-5 py-3"
                       style="font-size: 1.2rem;">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </a>
                </div>
                <p class="text-muted small">
                    Reserva tu turno de forma rápida y sencilla | 
                    <a href="{{ route('login') }}" class="text-decoration-none">Acceso para Barberos y Administradores</a>
                </p>
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
                <h2 class="mb-2">
                    <i class="bi bi-calendar-check"></i> Turnos pendientes de confirmación
                </h2>
                <p class="text-muted mb-4">
                    Tu solicitud está en espera de aprobación por el barbero. 
                    La confirmación o rechazo se realizará por WhatsApp.
                </p>
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
                                                // Obtener número de WhatsApp del barbero
                                                $whatsappNumber = $turno->barbero->telefono ?? null;
                                                
                                                // Limpiar y normalizar el número para WhatsApp
                                                if ($whatsappNumber) {
                                                    // Quitar espacios, guiones, paréntesis y el signo +
                                                    $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
                                                    
                                                    // Si el número no empieza con código de país (57 para Colombia), agregarlo
                                                    // Asumiendo que números de 10 dígitos son colombianos sin código de país
                                                    if (strlen($whatsappNumber) == 10 && substr($whatsappNumber, 0, 1) == '3') {
                                                        // Es un número celular colombiano sin código de país
                                                        $whatsappNumber = '57' . $whatsappNumber;
                                                    }
                                                }
                                                
                                                // Construir mensaje
                                                $mensaje = "Hola " . $turno->barbero->nombre . ", me interesa el turno del " . $turno->fecha->format('d/m/Y') . " a las " . $turno->hora . " - Servicio: " . $turno->servicio->nombre;
                                                
                                                // URL de WhatsApp (solo si hay número disponible)
                                                $whatsappUrl = null;
                                                if ($whatsappNumber && !empty($whatsappNumber)) {
                                                    $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($mensaje);
                                                }
                                            @endphp
                                            @if($whatsappUrl)
                                                <a href="{{ $whatsappUrl }}" 
                                                   class="btn btn-sm btn-success" 
                                                   target="_blank">
                                                    <i class="bi bi-whatsapp"></i> Reservar por WhatsApp
                                                </a>
                                            @else
                                                <span class="text-muted small">
                                                    <i class="bi bi-exclamation-triangle"></i> Sin WhatsApp
                                                </span>
                                            @endif
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

        <!-- Botón para mostrar formulario -->
        <div class="row mb-4" id="boton-reservar-container">
            <div class="col-12 text-center">
                <button type="button" 
                        class="btn btn-primary btn-lg" 
                        id="btn-mostrar-formulario"
                        onclick="mostrarFormulario()">
                    <i class="bi bi-calendar-plus"></i> Reservar Turno
                </button>
            </div>
        </div>

        <!-- Formulario de Solicitud de Turno -->
        <div class="row mb-5" id="formulario-turno-container" style="display: {{ (session('success') || session('error') || $errors->any()) ? 'block' : 'none' }};">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="bi bi-calendar-plus"></i> Solicitar Turno
                        </h3>
                        <button type="button" 
                                class="btn btn-sm btn-light" 
                                onclick="ocultarFormulario()"
                                title="Cerrar formulario">
                            <i class="bi bi-x-lg"></i>
                        </button>
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
                                    
                                    // Obtener número de WhatsApp del barbero
                                    $whatsappNumber = $turno['barbero_telefono'] ?? null;
                                    
                                    // Limpiar y normalizar el número para WhatsApp
                                    if ($whatsappNumber) {
                                        // Quitar espacios, guiones, paréntesis y el signo +
                                        $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
                                        
                                        // Si el número no empieza con código de país (57 para Colombia), agregarlo
                                        // Asumiendo que números de 10 dígitos son colombianos sin código de país
                                        if (strlen($whatsappNumber) == 10 && substr($whatsappNumber, 0, 1) == '3') {
                                            // Es un número celular colombiano sin código de país
                                            $whatsappNumber = '57' . $whatsappNumber;
                                        }
                                        // Si tiene menos de 10 dígitos o más de 15, puede estar mal formateado
                                        // Pero lo dejamos pasar para que WhatsApp lo valide
                                    }
                                    
                                    // Construir mensaje
                                    $mensaje = "Hola " . $turno['barbero'] . ", solicité un turno con la siguiente información:\n\n";
                                    $mensaje .= "👤 Cliente: " . $turno['nombre_cliente'] . "\n";
                                    $mensaje .= "✂️ Servicio: " . $turno['servicio'] . "\n";
                                    $mensaje .= "📅 Fecha: " . date('d/m/Y', strtotime($turno['fecha'])) . "\n";
                                    $mensaje .= "🕐 Hora: " . $turno['hora'] . "\n\n";
                                    $mensaje .= "Por favor, confírmame si está disponible.";
                                    
                                    // URL de WhatsApp (solo si hay número disponible)
                                    $whatsappUrl = null;
                                    if ($whatsappNumber && !empty($whatsappNumber)) {
                                        $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($mensaje);
                                    }
                                @endphp
                                
                                <div class="alert alert-info mt-3">
                                    <h5 class="alert-heading">
                                        <i class="bi bi-whatsapp"></i> ¿Deseas enviar la información por WhatsApp?
                                    </h5>
                                    <p class="mb-3">Puedes enviar los detalles de tu turno directamente al barbero <strong>{{ $turno['barbero'] }}</strong>:</p>
                                    <div class="mb-2">
                                        <strong>Cliente:</strong> {{ $turno['nombre_cliente'] }}<br>
                                        <strong>Barbero:</strong> {{ $turno['barbero'] }}<br>
                                        <strong>Servicio:</strong> {{ $turno['servicio'] }}<br>
                                        <strong>Fecha:</strong> {{ date('d/m/Y', strtotime($turno['fecha'])) }}<br>
                                        <strong>Hora:</strong> {{ $turno['hora'] }}
                                    </div>
                                    @if($whatsappUrl)
                                        <a href="{{ $whatsappUrl }}" 
                                           class="btn btn-success btn-lg" 
                                           target="_blank">
                                            <i class="bi bi-whatsapp"></i> Enviar por WhatsApp a {{ $turno['barbero'] }}
                                        </a>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <i class="bi bi-exclamation-triangle"></i> 
                                            El barbero no tiene número de WhatsApp configurado. 
                                            Por favor, contacta directamente con la barbería.
                                        </div>
                                    @endif
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
                                    <label for="telefono_cliente" class="form-label">
                                        <i class="bi bi-whatsapp text-success"></i> Teléfono / WhatsApp (opcional)
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('telefono_cliente') is-invalid @enderror" 
                                           id="telefono_cliente" 
                                           name="telefono_cliente" 
                                           value="{{ old('telefono_cliente') }}"
                                           placeholder="+57 300 123 4567">
                                    <small class="form-text text-muted">
                                        Para que el barbero pueda contactarte por WhatsApp
                                    </small>
                                    @error('telefono_cliente')
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

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} Sistema Barbería. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-muted">
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none me-3">
                            <i class="bi bi-person-badge"></i> Barbero
                        </a>
                        <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-shield-check"></i> Admin
                        </a>
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript para mostrar/ocultar formulario -->
    <script>
        function mostrarFormulario() {
            const formulario = document.getElementById('formulario-turno-container');
            const boton = document.getElementById('boton-reservar-container');
            
            if (formulario && boton) {
                formulario.style.display = 'block';
                boton.style.display = 'none';
                
                // Scroll suave al formulario
                formulario.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        function ocultarFormulario() {
            const formulario = document.getElementById('formulario-turno-container');
            const boton = document.getElementById('boton-reservar-container');
            
            if (formulario && boton) {
                formulario.style.display = 'none';
                boton.style.display = 'block';
                
                // Limpiar formulario si no hay errores
                const tieneErrores = document.querySelector('.alert-danger');
                if (!tieneErrores) {
                    const form = document.querySelector('form[action*="turnos/solicitar"]');
                    if (form) {
                        form.reset();
                    }
                }
            }
        }
        
        // Si hay mensajes de éxito, error o errores de validación, mostrar formulario automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            const tieneMensajes = document.querySelector('.alert-success, .alert-danger, .alert-info');
            if (tieneMensajes) {
                mostrarFormulario();
            }
        });
    </script>
</body>
</html>
