<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionApiController extends Controller
{
    public function index(Request $request)
    {
        $notificaciones = Notificacion::where('usuario_id', $request->user()->id)
            ->with('tarea')
            ->orderByDesc('created_at')
            ->get();

        $noLeidas = $notificaciones->where('leida', false)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'notificaciones' => $notificaciones,
                'no_leidas' => $noLeidas,
            ],
        ]);
    }

    public function marcarLeida(Notificacion $notificacion)
    {
        $notificacion->update(['leida' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída',
        ]);
    }

    public function marcarTodasLeidas(Request $request)
    {
        Notificacion::where('usuario_id', $request->user()->id)
            ->where('leida', false)
            ->update(['leida' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones marcadas como leídas',
        ]);
    }
}
