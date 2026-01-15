<?php

namespace Database\Seeders;

use App\Models\Barbero;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder principal de la base de datos
 * 
 * Crea datos de ejemplo para desarrollo
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecutar los seeders de la base de datos.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@barberia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Crear barberos de ejemplo
        $barbero1 = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@barberia.com',
            'password' => Hash::make('password'),
            'role' => 'barbero',
        ]);

        Barbero::create([
            'user_id' => $barbero1->id,
            'nombre' => 'Juan Pérez',
            'telefono' => '1234567890',
            'especialidad' => 'Cortes clásicos',
            'activo' => true,
        ]);

        $barbero2 = User::create([
            'name' => 'Carlos García',
            'email' => 'carlos@barberia.com',
            'password' => Hash::make('password'),
            'role' => 'barbero',
        ]);

        Barbero::create([
            'user_id' => $barbero2->id,
            'nombre' => 'Carlos García',
            'telefono' => '0987654321',
            'especialidad' => 'Barbas y bigotes',
            'activo' => true,
        ]);

        // Crear servicios de ejemplo
        Servicio::create([
            'nombre' => 'Corte de Cabello',
            'descripcion' => 'Corte de cabello profesional',
            'duracion' => 30,
            'precio' => 25.00,
            'activo' => true,
        ]);

        Servicio::create([
            'nombre' => 'Corte + Barba',
            'descripcion' => 'Corte de cabello y arreglo de barba',
            'duracion' => 45,
            'precio' => 40.00,
            'activo' => true,
        ]);

        Servicio::create([
            'nombre' => 'Arreglo de Barba',
            'descripcion' => 'Arreglo y perfilado de barba',
            'duracion' => 20,
            'precio' => 15.00,
            'activo' => true,
        ]);

        Servicio::create([
            'nombre' => 'Corte Premium',
            'descripcion' => 'Corte de cabello premium con productos especiales',
            'duracion' => 60,
            'precio' => 50.00,
            'activo' => true,
        ]);

        $this->command->info('Seeder ejecutado correctamente!');
        $this->command->info('Usuario admin: admin@barberia.com / password');
        $this->command->info('Usuario barbero: juan@barberia.com / password');
    }
}
