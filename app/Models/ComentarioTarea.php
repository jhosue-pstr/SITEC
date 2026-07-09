<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioTarea extends Model
{
    protected $table = 'comentarios_tarea';

    protected $fillable = [
        'tarea_id',
        'usuario_id',
        'comentario',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
