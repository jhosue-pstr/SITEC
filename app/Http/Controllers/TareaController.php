<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with(['solicitante', 'oficina', 'practicanteAsignado'])->get();

        return view('tareas.index', compact('tareas'));
    }

    public function create()
    {
        $oficinas = Oficina::all();
        $solicitantes = Usuario::whereIn('rol', ['solicitante', 'jefe'])->get();
        $practicantes = Usuario::where('rol', 'practicante')->get();

        return view('tareas.create', compact('oficinas', 'solicitantes', 'practicantes'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['estado'] = 'pendiente';
        Tarea::create($data);

        return redirect('/tareas');
    }

    public function show(Tarea $tarea)
    {
        $tarea->load(['solicitante', 'oficina', 'practicanteAsignado', 'atencion', 'evidencias.subidoPor', 'comentarios.usuario', 'asignaciones.practicante', 'notificaciones']);

        return view('tareas.show', compact('tarea'));
    }

    public function edit(Tarea $tarea)
    {
        $oficinas = Oficina::all();
        $solicitantes = Usuario::whereIn('rol', ['solicitante', 'jefe'])->get();
        $practicantes = Usuario::where('rol', 'practicante')->get();

        return view('tareas.edit', compact('tarea', 'oficinas', 'solicitantes', 'practicantes'));
    }

    public function update(Request $request, Tarea $tarea)
    {
        $tarea->update($request->all());

        return redirect('/tareas');
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();

        return redirect('/tareas');
    }

    public function asignar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'practicante_asignado_id' => $request->practicante_id,
            'estado' => 'asignado',
            'fecha_asignacion' => now(),
        ]);

        return redirect("/tareas/{$tarea->id}");
    }

    public function aceptar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'estado' => 'en_proceso',
            'fecha_inicio' => now(),
        ]);

        return redirect("/tareas/{$tarea->id}");
    }

    public function iniciar(Request $request, Tarea $tarea)
    {
        return $this->aceptar($request, $tarea);
    }

    public function finalizar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'estado' => 'finalizado',
            'fecha_finalizacion' => now(),
        ]);

        return redirect("/tareas/{$tarea->id}");
    }

    public function observar(Request $request, Tarea $tarea)
    {
        $tarea->update(['estado' => 'observado']);

        return redirect("/tareas/{$tarea->id}");
    }

    public function cancelar(Request $request, Tarea $tarea)
    {
        $tarea->update(['estado' => 'cancelado']);

        return redirect("/tareas/{$tarea->id}");
    }
}
