<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoApiController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with(['oficina', 'usuarioResponsable'])->get();

        return response()->json([
            'success' => true,
            'data' => $equipos,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_equipo' => 'required|string|max:255',
            'codigo_patrimonial' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'oficina_id' => 'nullable|integer|exists:oficinas,id',
            'usuario_responsable_id' => 'nullable|integer|exists:usuarios,id',
            'activo' => 'sometimes|boolean',
        ]);

        $equipo = Equipo::create($data);

        return response()->json([
            'success' => true,
            'data' => $equipo,
            'message' => 'Equipo registrado correctamente',
        ], 201);
    }

    public function update(Request $request, Equipo $equipo)
    {
        $data = $request->validate([
            'tipo_equipo' => 'sometimes|string|max:255',
            'codigo_patrimonial' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'oficina_id' => 'nullable|integer|exists:oficinas,id',
            'usuario_responsable_id' => 'nullable|integer|exists:usuarios,id',
            'activo' => 'sometimes|boolean',
        ]);

        $equipo->update($data);

        return response()->json([
            'success' => true,
            'data' => $equipo->fresh(),
            'message' => 'Equipo actualizado correctamente',
        ]);
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Equipo eliminado correctamente',
        ]);
    }
}
