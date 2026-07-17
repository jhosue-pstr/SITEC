<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Tarea::query();

        if ($user->rol === 'practicante') {
            $query->where(function ($q) use ($user) {
                $q->where('practicante_asignado_id', $user->id)
                    ->orWhere('estado', 'pendiente');
            });
        }

        $tareas = $query->get();

        $kanban = [
            'pendiente' => $tareas->where('estado', 'pendiente')->values(),
            'asignado' => $tareas->where('estado', 'asignado')->values(),
            'en_proceso' => $tareas->where('estado', 'en_proceso')->values(),
            'observado' => $tareas->where('estado', 'observado')->values(),
            'finalizado' => $tareas->where('estado', 'finalizado')->values(),
            'cancelado' => $tareas->where('estado', 'cancelado')->values(),
        ];

        $estadisticas = [
            'total' => $tareas->count(),
            'pendientes' => $tareas->where('estado', 'pendiente')->count(),
            'en_curso' => $tareas->whereIn('estado', ['asignado', 'en_proceso'])->count(),
            'finalizadas' => $tareas->where('estado', 'finalizado')->count(),
            'observadas' => $tareas->where('estado', 'observado')->count(),
            'canceladas' => $tareas->where('estado', 'cancelado')->count(),
        ];

        if ($user->rol === 'jefe') {
            $estadisticas['total_usuarios'] = Usuario::count();
            $estadisticas['total_practicantes'] = Usuario::where('rol', 'practicante')->count();
            $estadisticas['tareas_hoy'] = Tarea::whereDate('created_at', today())->count();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kanban' => $kanban,
                'estadisticas' => $estadisticas,
            ],
        ]);
    }
}
