<?php

namespace App\Http\Controllers;

/**
 * Controlador del Panel Administrador
 * 
 * Maneja el dashboard del administrador
 */
class AdminController extends Controller
{
    /**
     * Constructor: Aplicar middleware de autenticación y admin
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Mostrar el dashboard del administrador
     * 
     * Dashboard básico con enlaces a las secciones principales
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
