<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsignacionTarea;
use App\Models\Notificacion;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class TareaApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Tarea::with(['solicitante', 'oficina', 'practicanteAsignado']);

        if ($request->query('estado') === 'curso' && $user->rol === 'practicante') {
            $query->where('practicante_asignado_id', $user->id)
                ->whereIn('estado', ['asignado', 'en_proceso']);
        } elseif ($user->rol === 'practicante') {
            $query->where(function ($q) use ($user) {
                $q->where('practicante_asignado_id', $user->id)
                    ->orWhere('estado', 'pendiente');
            });
        }

        if ($request->has('estado') && $request->query('estado') !== 'curso') {
            $query->where('estado', $request->query('estado'));
        }

        if ($request->has('busqueda')) {
            $busqueda = $request->query('busqueda');
            $query->where(function ($q) use ($busqueda) {
                $q->where('codigo', 'like', "%{$busqueda}%")
                    ->orWhere('titulo', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%");
            });
        }

        $tareas = $query->orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'data' => $tareas,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo_soporte' => 'nullable|string',
            'prioridad' => 'nullable|string',
            'ubicacion_detalle' => 'nullable|string',
            'solicitante_id' => 'nullable|integer|exists:usuarios,id',
            'oficina_id' => 'nullable|integer|exists:oficinas,id',
        ]);

        $ultimoCodigo = Tarea::orderBy('id', 'desc')->first();
        $numero = $ultimoCodigo ? intval(substr($ultimoCodigo->codigo, 2)) + 1 : 1;
        $data['codigo'] = 'T-'.str_pad($numero, 3, '0', STR_PAD_LEFT);
        $data['estado'] = 'pendiente';
        $data['solicitante_id'] = $data['solicitante_id'] ?? $request->user()->id;

        $tarea = Tarea::create($data);

        $jefe = Usuario::where('rol', 'jefe')->first();
        if ($jefe) {
            Notificacion::create([
                'usuario_id' => $jefe->id,
                'tarea_id' => $tarea->id,
                'titulo' => 'Nueva solicitud creada',
                'mensaje' => "Se creó la solicitud {$tarea->codigo}: {$tarea->titulo}",
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $tarea->load(['solicitante', 'oficina']),
            'message' => 'Tarea creada correctamente',
        ], 201);
    }

    public function show(Tarea $tarea)
    {
        $tarea->load([
            'solicitante', 'oficina', 'practicanteAsignado',
            'atencion', 'evidencias.subidoPor', 'comentarios.usuario',
            'asignaciones.practicante', 'notificaciones', 'formatoAtencion',
        ]);

        return response()->json([
            'success' => true,
            'data' => $tarea,
        ]);
    }

    public function update(Request $request, Tarea $tarea)
    {
        $data = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'tipo_soporte' => 'nullable|string',
            'prioridad' => 'nullable|string',
            'ubicacion_detalle' => 'nullable|string',
            'solicitante_id' => 'nullable|integer|exists:usuarios,id',
            'oficina_id' => 'nullable|integer|exists:oficinas,id',
        ]);

        $tarea->update($data);

        return response()->json([
            'success' => true,
            'data' => $tarea->fresh(),
            'message' => 'Tarea actualizada correctamente',
        ]);
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tarea eliminada correctamente',
        ]);
    }

    public function asignar(Request $request, Tarea $tarea)
    {
        $data = $request->validate([
            'practicante_ids' => 'required|array|min:1',
            'practicante_ids.*' => 'integer|exists:usuarios,id',
        ]);

        AsignacionTarea::where('tarea_id', $tarea->id)->where('activa', true)
            ->update(['activa' => false, 'fecha_fin_asignacion' => now()]);

        foreach ($data['practicante_ids'] as $practicanteId) {
            AsignacionTarea::create([
                'tarea_id' => $tarea->id,
                'practicante_id' => $practicanteId,
                'tipo_asignacion' => 'manual',
                'asignado_por_id' => $request->user()->id,
                'activa' => true,
                'fecha_asignacion' => now(),
            ]);
        }

        $tarea->update([
            'practicante_asignado_id' => $data['practicante_ids'][0],
            'estado' => 'asignado',
            'fecha_asignacion' => now(),
        ]);

        foreach ($data['practicante_ids'] as $practicanteId) {
            Notificacion::create([
                'usuario_id' => $practicanteId,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea asignada',
                'mensaje' => "Se te ha asignado la tarea {$tarea->codigo}: {$tarea->titulo}",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea asignada correctamente',
        ]);
    }

    public function aceptar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'estado' => 'en_proceso',
            'fecha_inicio' => now(),
        ]);

        $jefe = Usuario::where('rol', 'jefe')->first();
        if ($jefe) {
            Notificacion::create([
                'usuario_id' => $jefe->id,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea en proceso',
                'mensaje' => "La tarea {$tarea->codigo} fue aceptada y está en proceso",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea en proceso',
        ]);
    }

    public function iniciar(Request $request, Tarea $tarea)
    {
        return $this->aceptar($request, $tarea);
    }

    public function autoasignar(Request $request, Tarea $tarea)
    {
        $user = $request->user();

        if ($user->rol !== 'practicante') {
            return response()->json([
                'success' => false,
                'message' => 'Solo los practicantes pueden auto-asignarse tareas.',
            ], 403);
        }

        $tarea->update([
            'practicante_asignado_id' => $user->id,
            'estado' => 'en_proceso',
            'fecha_asignacion' => now(),
            'fecha_inicio' => now(),
        ]);

        AsignacionTarea::create([
            'tarea_id' => $tarea->id,
            'practicante_id' => $user->id,
            'tipo_asignacion' => 'auto',
            'asignado_por_id' => $user->id,
            'activa' => true,
            'fecha_asignacion' => now(),
        ]);

        $jefe = Usuario::where('rol', 'jefe')->first();
        if ($jefe) {
            Notificacion::create([
                'usuario_id' => $jefe->id,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea auto-asignada',
                'mensaje' => "{$user->nombres} tomó la tarea {$tarea->codigo}",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea auto-asignada',
        ]);
    }

    public function finalizar(Request $request, Tarea $tarea)
    {
        $tarea->update([
            'estado' => 'finalizado',
            'fecha_finalizacion' => now(),
        ]);

        $jefe = Usuario::where('rol', 'jefe')->first();
        if ($jefe) {
            Notificacion::create([
                'usuario_id' => $jefe->id,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea finalizada',
                'mensaje' => "La tarea {$tarea->codigo} ha sido finalizada",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea finalizada. Completa el formato de atención.',
        ]);
    }

    public function observar(Request $request, Tarea $tarea)
    {
        $tarea->update(['estado' => 'observado']);

        if ($tarea->practicante_asignado_id) {
            Notificacion::create([
                'usuario_id' => $tarea->practicante_asignado_id,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea observada',
                'mensaje' => "La tarea {$tarea->codigo} fue marcada como observada",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea marcada como observada',
        ]);
    }

    public function cancelar(Request $request, Tarea $tarea)
    {
        $tarea->update(['estado' => 'cancelado']);

        $notificarA = $tarea->practicante_asignado_id ?? Usuario::where('rol', 'jefe')->first()?->id;
        if ($notificarA) {
            Notificacion::create([
                'usuario_id' => $notificarA,
                'tarea_id' => $tarea->id,
                'titulo' => 'Tarea cancelada',
                'mensaje' => "La tarea {$tarea->codigo} ha sido cancelada",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tarea cancelada',
        ]);
    }
}
