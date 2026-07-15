<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaSatisfaccion extends Model
{
    protected $table = 'encuestas_satisfaccion';

    protected $fillable = [
        'tarea_id',
        'numero_whatsapp',
        'calificacion',
        'comentario',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}
