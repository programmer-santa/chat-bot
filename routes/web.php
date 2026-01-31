<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberoController;
use App\Http\Controllers\BarberoPanelController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas son cargadas por el RouteServiceProvider y todas ellas
| tendrán el grupo de middleware "web".
|
*/

// Ruta raíz: redirigir al formulario de turnos
Route::get('/', function () {
    return redirect()->route('turnos.crear');
});

// Rutas públicas - Agendamiento de turnos
Route::get('/turnos/crear', [TurnoController::class, 'crearPublico'])->name('turnos.crear');
Route::post('/turnos', [TurnoController::class, 'guardarPublico'])->name('turnos.guardar');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Ruta de logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas - Panel Administrador
// Solo usuarios con rol 'admin' pueden acceder
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard del administrador
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD de Barberos
    Route::resource('barberos', BarberoController::class);
    
    // CRUD de Servicios
    Route::resource('servicios', ServicioController::class);
    
    // Listado de Turnos (solo lectura para admin)
    Route::get('/turnos', [TurnoController::class, 'index'])->name('turnos.index');
});

// Rutas protegidas - Panel Barbero
// Solo usuarios con rol 'barbero' pueden acceder
Route::middleware(['auth', 'barbero'])->prefix('barbero')->name('barbero.')->group(function () {
    // Dashboard del barbero
    Route::get('/dashboard', [BarberoPanelController::class, 'dashboard'])->name('dashboard');
    
    // Aceptar y rechazar turnos
    Route::post('/turnos/{turno}/aceptar', [BarberoPanelController::class, 'aceptar'])->name('turnos.aceptar');
    Route::post('/turnos/{turno}/rechazar', [BarberoPanelController::class, 'rechazar'])->name('turnos.rechazar');
});
