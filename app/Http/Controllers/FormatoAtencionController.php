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
        $equipos = Equipo::all();

        return view('formatos-atencion.create', compact('tarea', 'equipos'));
    }

    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->all();
        $data['tarea_id'] = $tarea->id;
        $data['responsable_atencion_id'] = auth()->id();
        FormatoAtencion::create($data);

        return redirect("/tareas/{$tarea->id}");
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

        return redirect('/formatos-atencion');
    }

    public function destroy(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->delete();

        return redirect('/formatos-atencion');
    }
}
