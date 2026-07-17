<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oficina;
use Illuminate\Http\Request;

class OficinaApiController extends Controller
{
    public function index()
    {
        $oficinas = Oficina::with('equipos')->get();

        return response()->json([
            'success' => true,
            'data' => $oficinas,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $oficina = Oficina::create($data);

        return response()->json([
            'success' => true,
            'data' => $oficina,
            'message' => 'Oficina creada correctamente',
        ], 201);
    }

    public function update(Request $request, Oficina $oficina)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'ubicacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $oficina->update($data);

        return response()->json([
            'success' => true,
            'data' => $oficina->fresh(),
            'message' => 'Oficina actualizada correctamente',
        ]);
    }

    public function destroy(Oficina $oficina)
    {
        $oficina->delete();

        return response()->json([
            'success' => true,
            'message' => 'Oficina eliminada correctamente',
        ]);
    }
}
