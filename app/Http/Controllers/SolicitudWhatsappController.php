<?php

namespace App\Http\Controllers;

use App\Models\SolicitudWhatsapp;
use Illuminate\Http\Request;

class SolicitudWhatsappController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudWhatsapp::with('tarea')->orderByDesc('created_at')->get();

        return view('solicitudes-whatsapp.index', compact('solicitudes'));
    }

    public function store(Request $request)
    {
        SolicitudWhatsapp::create($request->all());

        return redirect('/solicitudes-whatsapp');
    }
}
