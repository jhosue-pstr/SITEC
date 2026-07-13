<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenciaController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->all();
        $data['tarea_id'] = $tarea->id;
        $data['subido_por_id'] = auth()->id();

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('evidencias', 'public');
            $data['url_archivo'] = $path;
            $data['nombre_archivo'] = $data['nombre_archivo'] ?? $request->file('archivo')->getClientOriginalName();
        }

        Evidencia::create($data);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Evidencia subida correctamente');
    }

    public function destroy(Evidencia $evidencia)
    {
        if ($evidencia->url_archivo && ! str_starts_with($evidencia->url_archivo, 'http')) {
            Storage::disk('public')->delete($evidencia->url_archivo);
        }

        $tarea_id = $evidencia->tarea_id;
        $evidencia->delete();

        return redirect("/tareas/{$tarea_id}")->with('toast_success', 'Evidencia eliminada');
    }
}
