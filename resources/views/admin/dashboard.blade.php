@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <!-- Título del Panel -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">
                    <i class="bi bi-speedometer2"></i> Panel de Administración
                </h2>
            </div>
            <div class="card-body">
                <!-- Mensaje de bienvenida -->
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">
                        <i class="bi bi-person-check"></i> ¡Bienvenido, {{ auth()->user()->name }}!
                    </h4>
                    <p class="mb-0">
                        Desde aquí puedes gestionar todos los aspectos del sistema de barbería.
                    </p>
                </div>

                <!-- Enlaces a las secciones -->
                <div class="row mt-4">
                    <!-- Gestión de Barberos -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-people-fill text-primary" style="font-size: 3rem;"></i>
                                <h5 class="card-title mt-3">Gestión de Barberos</h5>
                                <p class="card-text text-muted">
                                    Administra los barberos del sistema
                                </p>
                                <a href="#" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Servicios -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-list-check text-success" style="font-size: 3rem;"></i>
                                <h5 class="card-title mt-3">Gestión de Servicios</h5>
                                <p class="card-text text-muted">
                                    Administra los servicios ofrecidos
                                </p>
                                <a href="#" class="btn btn-success">
                                    <i class="bi bi-box-arrow-in-right"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Turnos -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-info">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-check text-info" style="font-size: 3rem;"></i>
                                <h5 class="card-title mt-3">Gestión de Turnos</h5>
                                <p class="card-text text-muted">
                                    Administra los turnos y citas
                                </p>
                                <a href="#" class="btn btn-info">
                                    <i class="bi bi-box-arrow-in-right"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
