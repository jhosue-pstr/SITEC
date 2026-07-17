<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioApiController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();

        return response()->json([
            'success' => true,
            'data' => $usuarios,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|in:jefe,practicante,solicitante',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['activo'] = true;

        $user = Usuario::create($data);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Usuario creado correctamente',
        ], 201);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombres' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:usuarios,correo,'.$usuario->id,
            'telefono' => 'nullable|string|max:20',
            'rol' => 'sometimes|in:jefe,practicante,solicitante',
            'activo' => 'sometimes|boolean',
            'password' => 'sometimes|string|min:6',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return response()->json([
            'success' => true,
            'data' => $usuario->fresh(),
            'message' => 'Usuario actualizado correctamente',
        ]);
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente',
        ]);
    }
}
