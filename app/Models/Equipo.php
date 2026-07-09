<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'tipo_equipo',
        'codigo_patrimonial',
        'numero_serie',
        'marca',
        'modelo',
        'oficina_id',
        'usuario_responsable_id',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class);
    }

    public function usuarioResponsable()
    {
        return $this->belongsTo(Usuario::class, 'usuario_responsable_id');
    }
}
