<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTarea;
use App\Models\Tarea;
use Illuminate\Http\Request;

class AsignacionTareaController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        AsignacionTarea::create([
            'tarea_id' => $tarea->id,
            'practicante_id' => $request->practicante_id,
            'tipo_asignacion' => $request->tipo_asignacion ?? 'manual',
            'asignado_por_id' => auth()->id(),
        ]);

        $tarea->update([
            'practicante_asignado_id' => $request->practicante_id,
            'estado' => 'asignado',
            'fecha_asignacion' => now(),
        ]);

        return redirect("/tareas/{$tarea->id}");
    }

    public function destroy(AsignacionTarea $asignacionTarea)
    {
        $tarea = $asignacionTarea->tarea;
        $asignacionTarea->update(['activa' => false, 'fecha_fin_asignacion' => now()]);

        $tarea->update([
            'practicante_asignado_id' => null,
            'estado' => 'pendiente',
            'fecha_asignacion' => null,
        ]);

        return redirect("/tareas/{$tarea->id}");
    }
}
