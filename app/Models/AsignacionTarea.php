<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionTarea extends Model
{
    protected $table = 'asignaciones_tarea';

    protected $fillable = [
        'tarea_id',
        'practicante_id',
        'tipo_asignacion',
        'asignado_por_id',
        'fecha_asignacion',
        'fecha_fin_asignacion',
        'activa',
    ];

    protected function casts(): array
    {
        return [
            'activa' => 'boolean',
            'fecha_asignacion' => 'datetime',
            'fecha_fin_asignacion' => 'datetime',
        ];
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function practicante()
    {
        return $this->belongsTo(Usuario::class, 'practicante_id');
    }

    public function asignadoPor()
    {
        return $this->belongsTo(Usuario::class, 'asignado_por_id');
    }
}
