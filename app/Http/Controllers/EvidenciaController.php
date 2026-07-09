<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Tarea;
use Illuminate\Http\Request;

class EvidenciaController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->all();
        $data['tarea_id'] = $tarea->id;
        $data['subido_por_id'] = auth()->id();
        Evidencia::create($data);

        return redirect("/tareas/{$tarea->id}");
    }

    public function destroy(Evidencia $evidencia)
    {
        $tarea_id = $evidencia->tarea_id;
        $evidencia->delete();

        return redirect("/tareas/{$tarea_id}");
    }
}
