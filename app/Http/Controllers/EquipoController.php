<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Oficina;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::all();

        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        $oficinas = Oficina::all();
        $usuarios = Usuario::all();

        return view('equipos.create', compact('oficinas', 'usuarios'));
    }

    public function store(Request $request)
    {
        Equipo::create($request->all());

        return redirect('/equipos')->with('toast_success', 'Equipo registrado');
    }

    public function edit(Equipo $equipo)
    {
        $oficinas = Oficina::all();
        $usuarios = Usuario::all();

        return view('equipos.edit', compact('equipo', 'oficinas', 'usuarios'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $equipo->update($request->all());

        return redirect('/equipos')->with('toast_success', 'Equipo actualizado');
    }

    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        return redirect('/equipos')->with('toast_success', 'Equipo eliminado');
    }
}
