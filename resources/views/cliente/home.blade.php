<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EL BUNKER - Barbería Salón | Reserva tu Turno</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Estilos EL BUNKER -->
    <link rel="stylesheet" href="{{ asset('css/bunker-style.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="bunker-header">
        <div class="container">
            <a href="{{ route('cliente.home') }}" class="bunker-logo">
                <div class="barber-pole" style="width: 50px; height: 50px; margin-right: 15px;"></div>
                <div class="bunker-logo-text">
                    <span class="bunker-logo-name">EL BUNKER</span>
                    <span class="bunker-logo-subtitle">Barbería Salón</span>
                </div>
            </a>
            <div>
                <a href="{{ route('login') }}" class="btn btn-bunker-outline" style="color: white; border-color: white;">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bunker-hero-enhanced">
        <div class="container">
            <!-- Plantas decorativas -->
            <div class="plant-decoration plant-decoration-left">
                <i class="bi bi-flower1 plant-icon"></i>
                <i class="bi bi-flower2 plant-icon" style="margin-left: 20px; margin-top: 30px;"></i>
            </div>
            <div class="plant-decoration plant-decoration-right">
                <i class="bi bi-flower1 plant-icon"></i>
                <i class="bi bi-flower2 plant-icon" style="margin-left: -20px; margin-top: 30px;"></i>
            </div>
            
            <div class="bunker-hero-content">
                <!-- Barber Pole a la izquierda -->
                <div class="bunker-hero-left">
                    <div class="barber-pole-container barber-pole-left">
                        <div class="barber-pole"></div>
                    </div>
                </div>
                
                <!-- Contenido principal -->
                <div class="bunker-hero-right">
                    <!-- Logo circular EL BUNKER -->
                    <div class="bunker-logo-circle">
                        <div class="bunker-logo-circle-text">
                            <div class="bunker-logo-circle-name">EL BUNKER</div>
                            <div class="bunker-logo-circle-subtitle">BARBERÍA<br>SALÓN</div>
                        </div>
                    </div>
                    
                    <h1 class="bunker-title-main">EL BUNKER</h1>
                    <p class="bunker-subtitle">Barbería Salón</p>
                    <p class="mt-3" style="font-size: 1.1rem; color: var(--color-gris); max-width: 600px;">
                        Experiencia de barbería profesional con tradición y estilo moderno. Reserva tu turno y disfruta de nuestros servicios de calidad.
                    </p>
                    
                    <div id="boton-reservar-container" class="mt-4 d-flex flex-column flex-md-row gap-3">
                        <button type="button" class="btn btn-bunker btn-bunker-lg" onclick="mostrarFormulario()">
                            <i class="bi bi-calendar-plus"></i> Reservar Turno
                        </button>
                        <button type="button" class="btn btn-bunker-outline btn-bunker-lg" onclick="mostrarFormulario()">
                            <i class="bi bi-arrow-right-circle"></i> Continuar sin iniciar sesión
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario de Reserva (Oculto inicialmente) -->
    <section id="formulario-turno-container" class="bunker-section" style="display: none;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bunker-card">
                        <div class="bunker-card-header">
                            <h2 class="bunker-card-title">
                                <i class="bi bi-calendar-check"></i> Solicitar Turno
                            </h2>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            
                            @if(session('turno_creado'))
                                @php
                                    $turno = session('turno_creado');
                                    $barberoTelefono = $turno['barbero_telefono'] ?? null;
                                    
                                    // Preparar mensaje para WhatsApp (formato original)
                                    $mensaje = "Hola " . $turno['barbero'] . ", solicité un turno con la siguiente información:\n\n";
                                    $mensaje .= "• Cliente: " . $turno['nombre_cliente'] . "\n";
                                    $mensaje .= "• Servicio: " . $turno['servicio'] . "\n";
                                    $mensaje .= "• Fecha: " . date('d/m/Y', strtotime($turno['fecha'])) . "\n";
                                    $mensaje .= "• Hora: " . $turno['hora'] . "\n\n";
                                    $mensaje .= "Por favor, confírmame si está disponible.";
                                    
                                    // Limpiar teléfono para WhatsApp (solo números)
                                    $telefonoLimpio = $barberoTelefono ? preg_replace('/[^0-9]/', '', $barberoTelefono) : null;
                                    $whatsappUrl = $telefonoLimpio ? "https://wa.me/" . $telefonoLimpio . "?text=" . urlencode($mensaje) : null;
                                @endphp
                                
                                <!-- Resumen del turno para confirmación -->
                                <div class="card mt-3 mb-3" style="border: 2px solid var(--color-cafe-madera); background: var(--color-blanco);">
                                    <div class="card-header" style="background: var(--color-cafe-madera); color: var(--color-blanco);">
                                        <h5 class="mb-0">
                                            <i class="bi bi-calendar-check"></i> Resumen de tu solicitud de turno
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-info-circle"></i> 
                                            Por favor, verifica que los siguientes datos sean correctos:
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <i class="bi bi-person-fill text-primary me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <strong>Cliente:</strong>
                                                        <p class="mb-0">{{ $turno['nombre_cliente'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <i class="bi bi-scissors text-primary me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <strong>Servicio:</strong>
                                                        <p class="mb-0">{{ $turno['servicio'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <i class="bi bi-person-badge text-primary me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <strong>Barbero:</strong>
                                                        <p class="mb-0">{{ $turno['barbero'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <i class="bi bi-calendar-date text-primary me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <strong>Fecha:</strong>
                                                        <p class="mb-0">{{ date('d/m/Y', strtotime($turno['fecha'])) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <i class="bi bi-clock text-primary me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <strong>Hora:</strong>
                                                        <p class="mb-0">{{ $turno['hora'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($whatsappUrl)
                                    <div class="alert alert-info mt-3" role="alert">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div>
                                                <i class="bi bi-whatsapp text-success" style="font-size: 1.5rem;"></i>
                                                <strong>¿Quieres contactar al barbero por WhatsApp?</strong>
                                                <p class="mb-0 mt-2">Envía un mensaje directo para confirmar tu turno con los datos mostrados arriba</p>
                                            </div>
                                            <a href="{{ $whatsappUrl }}" 
                                               target="_blank" 
                                               class="btn btn-success btn-lg">
                                                <i class="bi bi-whatsapp"></i> Contactar por WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('turnos.solicitar') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre_cliente" class="bunker-form-label">
                                        <i class="bi bi-person"></i> Nombre Completo *
                                    </label>
                                    <input type="text" 
                                           class="bunker-form-control @error('nombre_cliente') is-invalid @enderror" 
                                           id="nombre_cliente" 
                                           name="nombre_cliente" 
                                           value="{{ old('nombre_cliente') }}"
                                           placeholder="Ingresa tu nombre completo"
                                           required>
                                    @error('nombre_cliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="telefono_cliente" class="bunker-form-label">
                                        <i class="bi bi-whatsapp text-success"></i> Teléfono / WhatsApp (opcional)
                                    </label>
                                    <input type="text" 
                                           class="bunker-form-control @error('telefono_cliente') is-invalid @enderror" 
                                           id="telefono_cliente" 
                                           name="telefono_cliente" 
                                           value="{{ old('telefono_cliente') }}"
                                           placeholder="+57 300 123 4567"
                                           maxlength="20"
                                           pattern="[\+]?[0-9\s\-\(\)]{10,20}"
                                           oninput="formatearTelefono(this)">
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i> 
                                            <strong>Formato:</strong> Incluye el código de país (+57 para Colombia).<br>
                                            <strong>Ejemplos válidos:</strong><br>
                                            • <code>+57 300 123 4567</code> (recomendado)<br>
                                            • <code>573001234567</code> (sin espacios)<br>
                                            • <code>300 123 4567</code> (se agregará +57 automáticamente)
                                        </small>
                                    </div>
                                    @error('telefono_cliente')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="barbero_id" class="bunker-form-label">
                                        <i class="bi bi-person-badge"></i> Seleccionar Barbero *
                                    </label>
                                    <select class="bunker-form-control @error('barbero_id') is-invalid @enderror" 
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
                                    <label for="servicio_id" class="bunker-form-label">
                                        <i class="bi bi-scissors"></i> Seleccionar Servicio *
                                    </label>
                                    <select class="bunker-form-control @error('servicio_id') is-invalid @enderror" 
                                            id="servicio_id" 
                                            name="servicio_id" 
                                            required>
                                        <option value="">-- Selecciona un servicio --</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('servicio_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="bunker-form-label">
                                        <i class="bi bi-calendar"></i> Fecha *
                                    </label>
                                    <input type="date" 
                                           class="bunker-form-control @error('fecha') is-invalid @enderror" 
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
                                    <label for="hora" class="bunker-form-label">
                                        <i class="bi bi-clock"></i> Hora *
                                    </label>
                                    <input type="time" 
                                           class="bunker-form-control @error('hora') is-invalid @enderror" 
                                           id="hora" 
                                           name="hora" 
                                           value="{{ old('hora') }}" 
                                           required>
                                    @error('hora')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="button" class="btn btn-bunker-outline" onclick="ocultarFormulario()">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-bunker">
                                    <i class="bi bi-check-circle"></i> Solicitar Turno
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Barberos -->
    @if($barberos->count() > 0)
    <section class="bunker-section-alt">
        <div class="container">
            <h2 class="text-center mb-5 text-bunker">
                <i class="bi bi-people"></i> Nuestros Barberos
            </h2>
            <div class="bunker-grid">
                @foreach($barberos as $barbero)
                    <div class="bunker-card">
                        <h5 class="bunker-card-title mb-3">
                            <i class="bi bi-person-badge"></i> {{ $barbero->nombre }}
                        </h5>
                        @if($barbero->especialidad)
                            <p class="mb-2">
                                <i class="bi bi-star-fill" style="color: #F4A460;"></i> 
                                <strong>Especialidad:</strong> {{ $barbero->especialidad }}
                            </p>
                        @endif
                        @if($barbero->telefono)
                            <p class="mb-0">
                                <i class="bi bi-telephone"></i> 
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $barbero->telefono) }}" 
                                   target="_blank" 
                                   class="text-decoration-none text-success">
                                    {{ $barbero->telefono }}
                                </a>
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Sección de Servicios -->
    @if($servicios->count() > 0)
    <section class="bunker-section">
        <div class="container">
            <h2 class="text-center mb-5 text-bunker">
                <i class="bi bi-scissors"></i> Nuestros Servicios
            </h2>
            <div class="bunker-grid">
                @foreach($servicios as $servicio)
                    <div class="bunker-card">
                        <h5 class="bunker-card-title mb-3">
                            <i class="bi bi-check-circle"></i> {{ $servicio->nombre }}
                        </h5>
                        @if($servicio->descripcion)
                            <p class="text-muted mb-3">{{ $servicio->descripcion }}</p>
                        @endif
                        <p class="mb-0">
                            <strong class="text-bunker" style="font-size: 1.2rem;">
                                ${{ number_format($servicio->precio, 0, ',', '.') }}
                            </strong>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Sección de Turnos Disponibles -->
    @if(isset($turnosDisponibles) && $turnosDisponibles->count() > 0)
    <section class="bunker-section-alt">
        <div class="container">
            <h2 class="text-center mb-5 text-bunker">
                <i class="bi bi-calendar-check"></i> Turnos Disponibles
            </h2>
            <div class="bunker-card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background-color: var(--color-madera); color: white;">
                            <tr>
                                <th><i class="bi bi-person-badge"></i> Barbero</th>
                                <th><i class="bi bi-scissors"></i> Servicio</th>
                                <th><i class="bi bi-calendar"></i> Fecha</th>
                                <th><i class="bi bi-clock"></i> Hora</th>
                                <th><i class="bi bi-info-circle"></i> Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($turnosDisponibles as $turno)
                                <tr>
                                    <td>
                                        @if($turno->barbero)
                                            {{ $turno->barbero->nombre }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($turno->servicio)
                                            {{ $turno->servicio->nombre }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $turno->fecha ? $turno->fecha->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $turno->hora ?? 'N/A' }}</td>
                                    <td>
                                        @if($turno->estado === 'pendiente')
                                            <span class="bunker-badge bunker-badge-warning">Pendiente</span>
                                        @elseif($turno->estado === 'aceptado')
                                            <span class="bunker-badge bunker-badge-success">Aceptado</span>
                                        @else
                                            <span class="bunker-badge bunker-badge-danger">Rechazado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="bunker-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} EL BUNKER - Barbería Salón. Todos los derechos reservados.</p>
            <p class="mt-2">
                <small>
                    <a href="{{ route('login') }}" class="text-white text-decoration-none">
                        <i class="bi bi-shield-check"></i> Acceso Administrativo
                    </a>
                </small>
            </p>
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
        
        // Función para formatear automáticamente el número de teléfono
        function formatearTelefono(input) {
            let valor = input.value;
            
            // Remover todo excepto números y el signo +
            let soloNumeros = valor.replace(/[^\d+]/g, '');
            
            // Si empieza con +, mantenerlo
            let tieneMas = soloNumeros.startsWith('+');
            let numeros = soloNumeros.replace(/\+/g, '');
            
            // Si tiene más de 2 dígitos y no empieza con 57, asumir que es colombiano
            if (numeros.length > 2 && !numeros.startsWith('57')) {
                // Si tiene 10 dígitos y empieza con 3, agregar 57
                if (numeros.length === 10 && numeros.startsWith('3')) {
                    numeros = '57' + numeros;
                }
            }
            
            // Formatear: +57 XXX XXX XXXX
            let formateado = '';
            if (tieneMas || numeros.startsWith('57')) {
                formateado = '+';
            }
            
            if (numeros.startsWith('57')) {
                formateado += '57';
                numeros = numeros.substring(2);
            }
            
            // Formatear el resto del número
            if (numeros.length > 0) {
                if (formateado.length > 0) {
                    formateado += ' ';
                }
                
                // Formatear como: XXX XXX XXXX
                if (numeros.length <= 3) {
                    formateado += numeros;
                } else if (numeros.length <= 6) {
                    formateado += numeros.substring(0, 3) + ' ' + numeros.substring(3);
                } else {
                    formateado += numeros.substring(0, 3) + ' ' + 
                                  numeros.substring(3, 6) + ' ' + 
                                  numeros.substring(6, 10);
                }
            }
            
            // Actualizar el valor del input
            input.value = formateado;
            
            // Validar en tiempo real
            validarTelefono(input);
        }
        
        // Función para validar el teléfono en tiempo real
        function validarTelefono(input) {
            let valor = input.value;
            let soloNumeros = valor.replace(/[^\d]/g, '');
            
            // Remover clases de validación anteriores
            input.classList.remove('is-valid', 'is-invalid');
            
            // Si está vacío, no validar (es opcional)
            if (valor.trim() === '') {
                return;
            }
            
            // Validar que tenga al menos 10 dígitos
            if (soloNumeros.length < 10) {
                input.classList.add('is-invalid');
                mostrarMensajeError(input, 'El teléfono debe tener al menos 10 dígitos');
                return;
            }
            
            // Validar que no tenga más de 15 dígitos
            if (soloNumeros.length > 15) {
                input.classList.add('is-invalid');
                mostrarMensajeError(input, 'El teléfono no puede tener más de 15 dígitos');
                return;
            }
            
            // Si pasa todas las validaciones
            input.classList.add('is-valid');
            ocultarMensajeError(input);
        }
        
        // Función para mostrar mensaje de error personalizado
        function mostrarMensajeError(input, mensaje) {
            // Remover mensaje anterior si existe
            ocultarMensajeError(input);
            
            // Crear elemento de mensaje
            let errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback d-block';
            errorDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + mensaje;
            errorDiv.id = input.id + '_error';
            
            // Insertar después del input
            input.parentNode.insertBefore(errorDiv, input.nextSibling);
        }
        
        // Función para ocultar mensaje de error
        function ocultarMensajeError(input) {
            let errorDiv = document.getElementById(input.id + '_error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
        
        // Validar al enviar el formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="turnos/solicitar"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const telefonoInput = document.getElementById('telefono_cliente');
                    if (telefonoInput && telefonoInput.value.trim() !== '') {
                        validarTelefono(telefonoInput);
                        if (telefonoInput.classList.contains('is-invalid')) {
                            e.preventDefault();
                            telefonoInput.focus();
                            return false;
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
