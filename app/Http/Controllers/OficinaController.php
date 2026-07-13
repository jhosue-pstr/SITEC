<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
    public function index()
    {
        $oficinas = Oficina::all();

        return view('oficinas.index', compact('oficinas'));
    }

    public function create()
    {
        return view('oficinas.create');
    }

    public function store(Request $request)
    {
        Oficina::create($request->all());

        return redirect('/oficinas')->with('toast_success', 'Oficina creada');
    }

    public function edit(Oficina $oficina)
    {
        return view('oficinas.edit', compact('oficina'));
    }

    public function update(Request $request, Oficina $oficina)
    {
        $oficina->update($request->all());

        return redirect('/oficinas')->with('toast_success', 'Oficina actualizada');
    }

    public function destroy(Oficina $oficina)
    {
        $oficina->delete();

        return redirect('/oficinas')->with('toast_success', 'Oficina eliminada');
    }
}
