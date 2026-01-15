# Guía de Instalación - Sistema de Barbería

## Pasos para Instalar el Sistema

### 1. Requisitos Previos

Asegúrate de tener instalado:
- PHP >= 8.1
- Composer
- MySQL
- Extensiones PHP necesarias: PDO, MySQL, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON

### 2. Instalación de Dependencias

```bash
composer install
```

### 3. Configuración del Entorno

1. Copia el archivo `.env.example` a `.env`:
```bash
cp .env.example .env
```

2. Edita el archivo `.env` y configura tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barberia
DB_USERNAME=root
DB_PASSWORD=tu_password_aqui
```

3. Genera la clave de la aplicación:
```bash
php artisan key:generate
```

### 4. Crear la Base de Datos

Crea la base de datos en MySQL:
```sql
CREATE DATABASE barberia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Ejecutar Migraciones

```bash
php artisan migrate
```

Esto creará las siguientes tablas:
- `users` - Usuarios del sistema (admin y barberos)
- `barberos` - Perfiles de barberos
- `servicios` - Servicios ofrecidos
- `turnos` - Turnos/citas

### 6. Poblar Base de Datos (Opcional)

Para crear datos de ejemplo:
```bash
php artisan db:seed
```

Esto creará:
- 1 usuario administrador
- 2 barberos de ejemplo
- 4 servicios de ejemplo

### 7. Iniciar el Servidor

```bash
php artisan serve
```

El sistema estará disponible en: `http://localhost:8000`

## Credenciales por Defecto (después de ejecutar seeder)

### Administrador
- **Email:** admin@barberia.com
- **Contraseña:** password

### Barbero 1
- **Email:** juan@barberia.com
- **Contraseña:** password

### Barbero 2
- **Email:** carlos@barberia.com
- **Contraseña:** password

## Estructura de Roles

### Administrador
- Acceso completo al sistema
- Puede gestionar barberos, servicios y turnos
- Ve todas las estadísticas

### Barbero
- Acceso a su panel personal
- Puede ver sus turnos asignados
- Puede aceptar/rechazar turnos pendientes

## Solución de Problemas

### Error: "Class 'PDO' not found"
Instala la extensión PDO de PHP:
```bash
# Ubuntu/Debian
sudo apt-get install php-pdo php-mysql

# Windows (XAMPP/WAMP)
Ya viene incluido, verifica que esté habilitado en php.ini
```

### Error de conexión a la base de datos
- Verifica que MySQL esté corriendo
- Revisa las credenciales en `.env`
- Asegúrate de que la base de datos existe

### Error: "No application encryption key"
Ejecuta:
```bash
php artisan key:generate
```

## Próximos Pasos

Una vez instalado, puedes:
1. Iniciar sesión como administrador
2. Crear más barberos
3. Agregar servicios
4. Gestionar turnos

## Notas Importantes

- Cambia las contraseñas por defecto en producción
- Configura correctamente las variables de entorno
- Realiza backups regulares de la base de datos
- El sistema está listo para ser extendido con más funcionalidades
