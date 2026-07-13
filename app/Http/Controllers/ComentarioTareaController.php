<?php

namespace App\Http\Controllers;

use App\Models\ComentarioTarea;
use App\Models\Tarea;
use Illuminate\Http\Request;

class ComentarioTareaController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        ComentarioTarea::create([
            'tarea_id' => $tarea->id,
            'usuario_id' => auth()->id(),
            'comentario' => $request->comentario,
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Comentario agregado');
    }
}
