<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Barbero
 * 
 * Representa el perfil de barbero asociado a un usuario
 * Un barbero puede tener múltiples turnos asignados
 */
class Barbero extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nombre',
        'telefono',
        'especialidad',
        'activo', // true o false
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación: Un barbero pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un barbero puede tener múltiples turnos
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    /**
     * Scope para obtener solo barberos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
