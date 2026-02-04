<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EL BUNKER - Sistema Administrativo')</title>
    
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
    
    @stack('styles')
</head>
<body>
    @auth
        <nav class="bunker-header">
            <div class="container">
                <a class="bunker-logo" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('barbero.dashboard') }}">
                    <div class="barber-pole" style="width: 40px; height: 40px; margin-right: 12px;"></div>
                    <div class="bunker-logo-text">
                        <span class="bunker-logo-name">EL BUNKER</span>
                        <span class="bunker-logo-subtitle">Sistema Administrativo</span>
                    </div>
                </a>
                
                <!-- Menú móvil mejorado -->
                <button class="bunker-mobile-menu-btn d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Menú">
                    <i class="bi bi-list"></i>
                    <span>Menú</span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto bunker-nav-links" style="flex-direction: row; gap: 1rem;">
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}" style="color: white;">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.barberos.index') }}" style="color: white;">
                                    <i class="bi bi-people"></i> Barberos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.servicios.index') }}" style="color: white;">
                                    <i class="bi bi-list-ul"></i> Servicios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.turnos.index') }}" style="color: white;">
                                    <i class="bi bi-calendar-check"></i> Turnos
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('barbero.dashboard') }}" style="color: white;">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle bunker-user-menu" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bunker-user-info">
                                    <i class="bi bi-person-circle"></i> 
                                    <div class="bunker-user-details">
                                        <span class="bunker-user-label">MI PERFIL</span>
                                        <span class="bunker-user-name">{{ auth()->user()->name }}</span>
                                        <span class="bunker-user-role">
                                            @if(auth()->user()->isAdmin())
                                                Administrador
                                            @else
                                                Barbero
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-down bunker-dropdown-arrow"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.barberos.index') }}">
                                            <i class="bi bi-people"></i> Barberos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.servicios.index') }}">
                                            <i class="bi bi-list-ul"></i> Servicios
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.turnos.index') }}">
                                            <i class="bi bi-calendar-check"></i> Turnos
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cliente.home') }}">
                                            <i class="bi bi-house"></i> Volver al Inicio
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('barbero.dashboard') }}">
                                            <i class="bi bi-speedometer2"></i> Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cliente.home') }}">
                                            <i class="bi bi-house"></i> Volver al Inicio
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endauth

    <main class="container-fluid py-4">
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

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
