<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    protected $table = 'atenciones';

    protected $fillable = [
        'tarea_id',
        'practicante_id',
        'diagnostico',
        'actividades_realizadas',
        'solucion_aplicada',
        'observaciones',
        'tiempo_atencion_minutos',
        'fecha_atencion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_atencion' => 'datetime',
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

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class);
    }
}
