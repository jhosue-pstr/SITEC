<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'codigo',
        'titulo',
        'descripcion',
        'tipo_soporte',
        'prioridad',
        'estado',
        'ubicacion_detalle',
        'solicitante_id',
        'oficina_id',
        'practicante_asignado_id',
        'fecha_registro',
        'fecha_asignacion',
        'fecha_inicio',
        'fecha_finalizacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'datetime',
            'fecha_asignacion' => 'datetime',
            'fecha_inicio' => 'datetime',
            'fecha_finalizacion' => 'datetime',
        ];
    }

    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'solicitante_id');
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class);
    }

    public function practicanteAsignado()
    {
        return $this->belongsTo(Usuario::class, 'practicante_asignado_id');
    }

    public function atencion()
    {
        return $this->hasOne(Atencion::class);
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class);
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioTarea::class);
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionTarea::class);
    }

    public function formatoAtencion()
    {
        return $this->hasOne(FormatoAtencion::class);
    }
}
