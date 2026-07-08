<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $fillable = [
        'tarea_id',
        'atencion_id',
        'nombre_archivo',
        'url_archivo',
        'tipo_evidencia',
        'descripcion',
        'subido_por_id',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function atencion()
    {
        return $this->belongsTo(Atencion::class);
    }

    public function subidoPor()
    {
        return $this->belongsTo(Usuario::class, 'subido_por_id');
    }
}
