<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ComentarioTarea;
use App\Models\Tarea;
use Illuminate\Http\Request;

class ComentarioApiController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->validate([
            'comentario' => 'required|string',
        ]);

        $comentario = ComentarioTarea::create([
            'tarea_id' => $tarea->id,
            'usuario_id' => $request->user()->id,
            'comentario' => $data['comentario'],
        ]);

        $comentario->load('usuario');

        return response()->json([
            'success' => true,
            'data' => $comentario,
            'message' => 'Comentario agregado',
        ], 201);
    }
}
