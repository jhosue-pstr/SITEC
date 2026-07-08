<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudWhatsapp extends Model
{
    protected $table = 'solicitudes_whatsapp';

    protected $fillable = [
        'tarea_id',
        'numero_whatsapp',
        'mensaje_original',
        'estado_conversacion',
        'external_message_id',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}
