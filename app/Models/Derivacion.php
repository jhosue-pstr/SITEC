<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    protected $table = 'derivaciones';

    protected $fillable = [
        'tarea_id',
        'tipo',
        'tecnico_destino_id',
        'proveedor_nombre',
        'motivo',
        'derivado_por_id',
        'fecha_derivacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_derivacion' => 'datetime',
        ];
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function tecnicoDestino()
    {
        return $this->belongsTo(Usuario::class, 'tecnico_destino_id');
    }

    public function derivadoPor()
    {
        return $this->belongsTo(Usuario::class, 'derivado_por_id');
    }
}
