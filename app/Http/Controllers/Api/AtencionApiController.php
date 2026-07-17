<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Atencion;
use App\Models\Notificacion;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AtencionApiController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->validate([
            'diagnostico' => 'required|string',
            'actividades_realizadas' => 'nullable|string',
            'solucion_aplicada' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'tiempo_atencion_minutos' => 'nullable|integer|min:0',
        ]);

        $data['tarea_id'] = $tarea->id;
        $data['practicante_id'] = $request->user()->id;

        $atencion = Atencion::create($data);

        $jefe = Usuario::where('rol', 'jefe')->first();
        if ($jefe) {
            Notificacion::create([
                'usuario_id' => $jefe->id,
                'tarea_id' => $tarea->id,
                'titulo' => 'Atención registrada',
                'mensaje' => "Se registró la atención para la tarea {$tarea->codigo}",
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $atencion,
            'message' => 'Atención registrada correctamente',
        ], 201);
    }

    public function show(Atencion $atencion)
    {
        $atencion->load('tarea', 'practicante', 'evidencias');

        return response()->json([
            'success' => true,
            'data' => $atencion,
        ]);
    }

    public function update(Request $request, Atencion $atencion)
    {
        $data = $request->validate([
            'diagnostico' => 'sometimes|string',
            'actividades_realizadas' => 'nullable|string',
            'solucion_aplicada' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'tiempo_atencion_minutos' => 'nullable|integer|min:0',
        ]);

        $atencion->update($data);

        return response()->json([
            'success' => true,
            'data' => $atencion->fresh(),
            'message' => 'Atención actualizada correctamente',
        ]);
    }
}
