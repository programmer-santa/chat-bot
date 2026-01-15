<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Servicio
 * 
 * Representa los servicios que ofrece la barbería
 * Un servicio puede estar asociado a múltiples turnos
 */
class Servicio extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion', // en minutos
        'precio',
        'activo', // true o false
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Relación: Un servicio puede tener múltiples turnos
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    /**
     * Scope para obtener solo servicios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
