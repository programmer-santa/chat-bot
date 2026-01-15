<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberoController;
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

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas - Panel Administrador
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Barberos
    Route::resource('barberos', BarberoController::class);
    
    // CRUD Servicios
    Route::resource('servicios', ServicioController::class);
    
    // CRUD Turnos
    Route::resource('turnos', TurnoController::class);
    Route::post('/turnos/{turno}/cambiar-estado', [TurnoController::class, 'cambiarEstado'])
        ->name('turnos.cambiar-estado');
});

// Rutas protegidas - Panel Barbero
Route::middleware(['auth', 'barbero'])->prefix('barbero')->name('barbero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('barbero.dashboard');
    })->name('dashboard');
    
    // Los barberos pueden ver y gestionar sus turnos
    Route::get('/turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::get('/turnos/{turno}', [TurnoController::class, 'show'])->name('turnos.show');
    Route::post('/turnos/{turno}/cambiar-estado', [TurnoController::class, 'cambiarEstado'])
        ->name('turnos.cambiar-estado');
});
