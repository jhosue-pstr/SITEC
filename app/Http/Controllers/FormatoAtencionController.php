<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\FormatoAtencion;
use App\Models\Tarea;
use Illuminate\Http\Request;

class FormatoAtencionController extends Controller
{
    public function index()
    {
        $formatos = FormatoAtencion::with('tarea', 'equipo', 'responsable')->get();

        return view('formatos-atencion.index', compact('formatos'));
    }

    public function create(Tarea $tarea)
    {
        if ($tarea->formatoAtencion) {
            return redirect("/formatos-atencion/{$tarea->formatoAtencion->id}")
                ->with('toast_warning', 'Esta tarea ya tiene un formato de atención registrado.');
        }

        $tarea->load(['solicitante', 'atencion', 'practicanteAsignado']);
        $equipos = Equipo::all();

        $defaults = [
            'nombres_solicitante' => $tarea->solicitante->nombres ?? '',
            'apellidos_solicitante' => $tarea->solicitante->apellidos ?? '',
            'telefono_movil' => $tarea->solicitante->telefono ?? '',
            'tipo_soporte_informatico' => $tarea->tipo_soporte ?? '',
            'reporte_usuario' => $tarea->descripcion ?? '',
            'diagnostico_tecnico' => $tarea->atencion->diagnostico ?? '',
            'observaciones' => $tarea->atencion->observaciones ?? '',
            'fecha_atencion' => $tarea->atencion->fecha_atencion?->format('Y-m-d') ?? '',
            'hora_atencion' => $tarea->atencion->fecha_atencion?->format('H:i') ?? '',
            'fecha_entrega' => $tarea->fecha_finalizacion?->format('Y-m-d') ?? now()->format('Y-m-d'),
            'hora_entrega' => now()->format('H:i'),
            'nombre_responsable' => $tarea->practicanteAsignado
                ? trim($tarea->practicanteAsignado->nombres.' '.$tarea->practicanteAsignado->apellidos)
                : '',
        ];

        return view('formatos-atencion.create', compact('tarea', 'equipos', 'defaults'));
    }

    public function store(Request $request, Tarea $tarea)
    {
        if ($tarea->formatoAtencion) {
            return redirect("/formatos-atencion/{$tarea->formatoAtencion->id}")
                ->with('toast_error', 'Ya existe un formato de atención para esta tarea.');
        }

        $data = $request->all();
        $data['tarea_id'] = $tarea->id;
        $data['responsable_atencion_id'] = auth()->id();
        FormatoAtencion::create($data);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Formato de atención registrado');
    }

    public function show(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->load('tarea', 'equipo', 'responsable');

        return view('formatos-atencion.show', compact('formatoAtencion'));
    }

    public function edit(FormatoAtencion $formatoAtencion)
    {
        $equipos = Equipo::all();

        return view('formatos-atencion.edit', compact('formatoAtencion', 'equipos'));
    }

    public function update(Request $request, FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->update($request->all());

        return redirect('/formatos-atencion')->with('toast_success', 'Formato actualizado');
    }

    public function destroy(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->delete();

        return redirect('/formatos-atencion')->with('toast_success', 'Formato eliminado');
    }
}
