<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Notificacion;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AtencionController extends Controller
{
    public function create(Tarea $tarea)
    {
        return view('atenciones.create', compact('tarea'));
    }

    public function store(Request $request, Tarea $tarea)
    {
        $validated = $request->validate([
            'diagnostico' => 'required|string',
            'actividades_realizadas' => 'nullable|string',
            'solucion_aplicada' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'tiempo_atencion_minutos' => 'nullable|integer|min:0',
        ]);

        $validated['tarea_id'] = $tarea->id;
        $validated['practicante_id'] = auth()->id();
        Atencion::create($validated);

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Atención registrada',
            'mensaje' => "Se registró la atención para la tarea {$tarea->codigo}",
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Atención registrada correctamente');
    }

    public function edit(Atencion $atencion)
    {
        return view('atenciones.edit', compact('atencion'));
    }

    public function update(Request $request, Atencion $atencion)
    {
        $validated = $request->validate([
            'diagnostico' => 'required|string',
            'actividades_realizadas' => 'nullable|string',
            'solucion_aplicada' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'tiempo_atencion_minutos' => 'nullable|integer|min:0',
        ]);

        $atencion->update($validated);

        return redirect("/tareas/{$atencion->tarea_id}")->with('toast_success', 'Atención actualizada correctamente');
    }
}
