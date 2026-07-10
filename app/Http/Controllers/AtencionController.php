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
        $data = $request->all();
        $data['tarea_id'] = $tarea->id;
        $data['practicante_id'] = auth()->id();
        Atencion::create($data);

        $tarea->update(['estado' => 'finalizado', 'fecha_finalizacion' => now()]);

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Atención registrada',
            'mensaje' => "Se registró la atención para la tarea {$tarea->codigo}",
        ]);

        return redirect("/tareas/{$tarea->id}");
    }

    public function edit(Atencion $atencion)
    {
        return view('atenciones.edit', compact('atencion'));
    }

    public function update(Request $request, Atencion $atencion)
    {
        $atencion->update($request->all());

        return redirect("/tareas/{$atencion->tarea_id}");
    }
}
