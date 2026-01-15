<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Turno
 * 
 * Representa los turnos/citas de los clientes
 * Estados: pendiente, aceptado, rechazado
 */
class Turno extends Model
{
    use HasFactory;

    /**
     * Estados posibles del turno
     */
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_ACEPTADO = 'aceptado';
    const ESTADO_RECHAZADO = 'rechazado';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Cliente que solicita el turno
        'barbero_id',
        'servicio_id',
        'fecha',
        'hora',
        'estado', // pendiente, aceptado, rechazado
        'observaciones',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Relación: Un turno pertenece a un usuario (cliente)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un turno pertenece a un barbero
     */
    public function barbero()
    {
        return $this->belongsTo(Barbero::class);
    }

    /**
     * Relación: Un turno pertenece a un servicio
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para obtener turnos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    /**
     * Scope para obtener turnos aceptados
     */
    public function scopeAceptados($query)
    {
        return $query->where('estado', self::ESTADO_ACEPTADO);
    }

    /**
     * Verificar si el turno está pendiente
     */
    public function estaPendiente(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

    /**
     * Verificar si el turno está aceptado
     */
    public function estaAceptado(): bool
    {
        return $this->estado === self::ESTADO_ACEPTADO;
    }

    /**
     * Verificar si el turno está rechazado
     */
    public function estaRechazado(): bool
    {
        return $this->estado === self::ESTADO_RECHAZADO;
    }
}
