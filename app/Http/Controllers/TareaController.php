<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTarea;
use App\Models\Notificacion;
use App\Models\Oficina;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Tarea::with(['solicitante', 'oficina', 'practicanteAsignado']);

        if (request('estado') === 'curso' && $user->rol === 'practicante') {
            $query->where('practicante_asignado_id', $user->id)
                ->whereIn('estado', ['asignado', 'en_proceso']);
        } elseif ($user->rol === 'practicante') {
            $query->where(function ($q) use ($user) {
                $q->where('practicante_asignado_id', $user->id)
                    ->orWhere('estado', 'pendiente');
            });
        }

        $tareas = $query->get();

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
        $tarea = Tarea::create($data);

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Nueva solicitud creada',
            'mensaje' => "Se creó la solicitud {$tarea->codigo}: {$tarea->titulo}",
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea creada correctamente');
    }

    public function show(Tarea $tarea)
    {
        $tarea->load(['solicitante', 'oficina', 'practicanteAsignado', 'atencion', 'evidencias.subidoPor', 'comentarios.usuario', 'asignaciones.practicante', 'notificaciones']);

        $oficinas = Oficina::all();
        $solicitantes = Usuario::whereIn('rol', ['solicitante', 'jefe'])->get();
        $practicantes = Usuario::where('rol', 'practicante')->get();

        return view('tareas.show', compact('tarea', 'oficinas', 'solicitantes', 'practicantes'));
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

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea actualizada correctamente');
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();

        return redirect('/tareas')->with('toast_success', 'Tarea eliminada correctamente');
    }

    public function asignar(Request $request, Tarea $tarea)
    {
        $ids = $request->input('practicante_ids', []);

        if (empty($ids)) {
            return back()->with('toast_error', 'Selecciona al menos un técnico');
        }

        AsignacionTarea::where('tarea_id', $tarea->id)->where('activa', true)
            ->update(['activa' => false, 'fecha_fin_asignacion' => now()]);

        foreach ($ids as $practicanteId) {
            AsignacionTarea::create([
                'tarea_id' => $tarea->id,
                'practicante_id' => $practicanteId,
                'tipo_asignacion' => 'manual',
                'asignado_por_id' => auth()->id(),
                'activa' => true,
                'fecha_asignacion' => now(),
            ]);
        }

        $tarea->update([
            'practicante_asignado_id' => $ids[0],
            'estado' => 'asignado',
            'fecha_asignacion' => now(),
        ]);

        foreach ($ids as $practicanteId) {
            Notificacion::create([
                'usuario_id' => $practicanteId,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea asignada',
                'mensaje' => "Se te ha asignado la tarea {$tarea->codigo}: {$tarea->titulo}",
            ]);
        }

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea asignada correctamente');
    }

    public function aceptar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'estado' => 'en_proceso',
            'fecha_inicio' => now(),
        ]);

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Tarea en proceso',
            'mensaje' => "La tarea {$tarea->codigo} fue aceptada y está en proceso",
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea en proceso');
    }

    public function iniciar(Request $request, Tarea $tarea)
    {
        return $this->aceptar($request, $tarea);
    }

    public function autoasignar(Request $request, Tarea $tarea)
    {
        abort_if(auth()->user()->rol !== 'practicante', 403);

        $tarea->update([
            'practicante_asignado_id' => auth()->id(),
            'estado' => 'en_proceso',
            'fecha_asignacion' => now(),
            'fecha_inicio' => now(),
        ]);

        AsignacionTarea::create([
            'tarea_id' => $tarea->id,
            'practicante_id' => auth()->id(),
            'tipo_asignacion' => 'auto',
            'asignado_por_id' => auth()->id(),
            'activa' => true,
            'fecha_asignacion' => now(),
        ]);

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Tarea auto-asignada',
            'mensaje' => auth()->user()->nombres." tomó la tarea {$tarea->codigo}",
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea auto-asignada');
    }

    public function finalizar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'estado' => 'finalizado',
            'fecha_finalizacion' => now(),
        ]);

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Tarea finalizada',
            'mensaje' => "La tarea {$tarea->codigo} ha sido finalizada",
        ]);

        return redirect("/tareas/{$tarea->id}/formatos-atencion/create")->with('toast_success', 'Tarea finalizada. Completa el formato de atención.');
    }

    public function observar(Request $request, Tarea $tarea)
    {
        $tarea->update(['estado' => 'observado']);

        Notificacion::create([
            'usuario_id' => $tarea->practicante_asignado_id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Tarea observada',
            'mensaje' => "La tarea {$tarea->codigo} fue marcada como observada",
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea marcada como observada');
    }

    public function cancelar(Request $request, Tarea $tarea)
    {
        $tarea->update(['estado' => 'cancelado']);

        Notificacion::create([
            'usuario_id' => $tarea->practicante_asignado_id ?? Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Tarea cancelada',
            'mensaje' => "La tarea {$tarea->codigo} ha sido cancelada",
        ]);

        return redirect("/tareas/{$tarea->id}")->with('toast_success', 'Tarea cancelada');
    }
}
