<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoAtencion extends Model
{
    protected $table = 'formatos_atencion';

    protected $fillable = [
        'tarea_id',
        'equipo_id',
        'tipo_equipo',
        'codigo_patrimonial',
        'numero_serie',
        'marca',
        'modelo',
        'nombres_solicitante',
        'apellidos_solicitante',
        'dni_solicitante',
        'telefono_movil',
        'regimen_laboral',
        'regimen_laboral_especificar',
        'cargo',
        'unidad_organizacion',
        'tipo_soporte_informatico',
        'reporte_usuario',
        'diagnostico_tecnico',
        'observaciones',
        'fecha_atencion',
        'hora_atencion',
        'fecha_entrega',
        'hora_entrega',
        'responsable_atencion_id',
        'nombre_responsable',
        'firma_responsable_url',
        'firma_solicitante_url',
        'estado_formato',
        'pdf_url',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'responsable_atencion_id');
    }
}
