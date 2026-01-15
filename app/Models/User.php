<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo User
 * 
 * Representa a los usuarios del sistema (admin y barberos)
 * Los usuarios pueden tener el rol 'admin' o 'barbero'
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' o 'barbero'
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación: Un usuario puede tener un perfil de barbero
     */
    public function barbero()
    {
        return $this->hasOne(Barbero::class);
    }

    /**
     * Relación: Un usuario puede tener múltiples turnos
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar si el usuario es barbero
     */
    public function isBarbero(): bool
    {
        return $this->role === 'barbero';
    }
}
