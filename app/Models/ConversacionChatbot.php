<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversacionChatbot extends Model
{
    protected $table = 'conversaciones_chatbot';

    protected $fillable = [
        'numero_whatsapp',
        'estado',
        'datos_temp',
        'tarea_id',
    ];

    protected function casts(): array
    {
        return [
            'datos_temp' => 'array',
        ];
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}
