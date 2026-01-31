@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-scissors"></i> Sistema Barbería
                </h4>
            </div>
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>
                
                <div class="text-center mb-3">
                    <a href="{{ route('cliente.home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver a la página principal
                    </a>
                </div>
                
                <hr class="my-4">
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Correo Electrónico
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Contraseña
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-2">¿Eres cliente?</p>
                    <a href="{{ route('cliente.home') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-right-circle"></i> Continuar sin iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
