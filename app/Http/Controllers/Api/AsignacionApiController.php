<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsignacionTarea;
use App\Models\Tarea;
use Illuminate\Http\Request;

class AsignacionApiController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->validate([
            'practicante_id' => 'required|integer|exists:usuarios,id',
            'tipo_asignacion' => 'nullable|in:manual,auto',
        ]);

        $asignacion = AsignacionTarea::create([
            'tarea_id' => $tarea->id,
            'practicante_id' => $data['practicante_id'],
            'tipo_asignacion' => $data['tipo_asignacion'] ?? 'manual',
            'asignado_por_id' => $request->user()->id,
        ]);

        $tarea->update([
            'practicante_asignado_id' => $data['practicante_id'],
            'estado' => 'asignado',
            'fecha_asignacion' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $asignacion,
            'message' => 'Asignación registrada',
        ], 201);
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

        return response()->json([
            'success' => true,
            'message' => 'Asignación removida',
        ]);
    }
}
