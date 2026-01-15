# Sistema de Gestión para Barbería

Sistema completo desarrollado en Laravel para la gestión de una barbería, incluyendo administración de barberos, servicios y turnos.

## Características

- ✅ Autenticación con correo y contraseña
- ✅ Sistema de roles (admin y barbero)
- ✅ Panel administrador con estadísticas
- ✅ CRUD completo de barberos
- ✅ CRUD completo de servicios
- ✅ Gestión de turnos con estados (pendiente, aceptado, rechazado)
- ✅ Relaciones entre usuarios, barberos, servicios y turnos
- ✅ Validaciones del lado del servidor
- ✅ Rutas protegidas por middleware según rol
- ✅ Frontend con Blade y Bootstrap 5
- ✅ Código estructurado y comentado

## Requisitos

- PHP >= 8.1
- Composer
- MySQL
- Extensiones PHP: PDO, MySQL, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON

## Instalación

1. **Clonar o descargar el proyecto**

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar el archivo .env**
   ```bash
   cp .env.example .env
   ```
   
   Editar `.env` y configurar:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=barberia
   DB_USERNAME=root
   DB_PASSWORD=tu_password
   ```

4. **Generar clave de aplicación**
   ```bash
   php artisan key:generate
   ```

5. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

6. **Poblar base de datos con datos de ejemplo (opcional)**
   ```bash
   php artisan db:seed
   ```

7. **Iniciar servidor de desarrollo**
   ```bash
   php artisan serve
   ```

   El sistema estará disponible en: `http://localhost:8000`

## Credenciales por Defecto (después de ejecutar seeder)

### Administrador
- **Email:** admin@barberia.com
- **Contraseña:** password

### Barbero
- **Email:** juan@barberia.com
- **Contraseña:** password

## Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php      # Panel administrador
│   │   ├── AuthController.php       # Autenticación
│   │   ├── BarberoController.php    # CRUD barberos
│   │   ├── ServicioController.php   # CRUD servicios
│   │   └── TurnoController.php      # Gestión turnos
│   └── Middleware/
│       ├── EnsureUserIsAdmin.php    # Middleware admin
│       └── EnsureUserIsBarbero.php  # Middleware barbero
├── Models/
│   ├── User.php                      # Modelo usuario
│   ├── Barbero.php                   # Modelo barbero
│   ├── Servicio.php                  # Modelo servicio
│   └── Turno.php                     # Modelo turno
database/
├── migrations/                       # Migraciones de BD
└── seeders/
    └── DatabaseSeeder.php           # Seeder con datos ejemplo
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php            # Layout principal
    ├── auth/
    │   └── login.blade.php          # Vista login
    ├── admin/                       # Vistas panel admin
    └── barbero/                     # Vistas panel barbero
routes/
└── web.php                          # Rutas de la aplicación
```

## Funcionalidades

### Panel Administrador
- Dashboard con estadísticas generales
- Gestión completa de barberos (crear, editar, eliminar)
- Gestión completa de servicios (crear, editar, eliminar)
- Gestión de turnos (crear, editar, cambiar estado, eliminar)
- Visualización de turnos recientes

### Panel Barbero
- Dashboard con estadísticas personales
- Visualización de turnos asignados
- Aceptar/rechazar turnos pendientes

## Estados de Turnos

- **Pendiente:** Turno creado, esperando confirmación
- **Aceptado:** Turno confirmado por el barbero
- **Rechazado:** Turno rechazado por el barbero

## Tecnologías Utilizadas

- **Backend:** Laravel 10
- **Frontend:** Blade Templates + Bootstrap 5
- **Base de Datos:** MySQL
- **Autenticación:** Laravel Auth (Session)

## Buenas Prácticas Implementadas

- ✅ Arquitectura MVC
- ✅ Migraciones para control de versiones de BD
- ✅ Modelos con relaciones Eloquent
- ✅ Validaciones del lado del servidor
- ✅ Middleware para protección de rutas
- ✅ Código comentado y documentado
- ✅ Separación de responsabilidades
- ✅ Uso de Resource Controllers

## Notas

- El sistema está diseñado para ser fácilmente extensible
- Se pueden agregar más funcionalidades como:
  - Sistema de clientes
  - Calendario de turnos
  - Notificaciones
  - Reportes y estadísticas avanzadas
  - API REST

## Licencia

MIT
