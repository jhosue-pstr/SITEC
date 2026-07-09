<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    protected $fillable = [
        'nombre',
        'ubicacion',
        'descripcion',
    ];

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}
