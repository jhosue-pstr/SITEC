<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evidencia;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenciaApiController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $data = [
            'tarea_id' => $tarea->id,
            'subido_por_id' => $request->user()->id,
            'nombre_archivo' => $request->input('nombre_archivo', 'evidencia'),
            'descripcion' => $request->input('descripcion'),
            'tipo_evidencia' => $request->input('tipo_evidencia', 'imagen'),
        ];

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('evidencias', 'public');
            $data['url_archivo'] = $path;
            $data['nombre_archivo'] = $request->file('archivo')->getClientOriginalName();
        } elseif ($request->has('archivo_base64')) {
            $base64 = $request->input('archivo_base64');
            $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
            $imageData = base64_decode($base64);

            if ($imageData === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo base64 no es válido.',
                ], 422);
            }

            $extension = pathinfo($data['nombre_archivo'], PATHINFO_EXTENSION) ?: 'png';
            $filename = 'evidencias/'.$tarea->codigo.'_'.time().'.'.$extension;
            $fullPath = storage_path('app/public/'.$filename);

            Storage::disk('public')->makeDirectory('evidencias');
            file_put_contents($fullPath, $imageData);

            $data['url_archivo'] = $filename;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Debes enviar un archivo (multipart o base64).',
            ], 422);
        }

        $evidencia = Evidencia::create($data);

        return response()->json([
            'success' => true,
            'data' => $evidencia,
            'message' => 'Evidencia subida correctamente',
        ], 201);
    }

    public function destroy(Evidencia $evidencia)
    {
        if ($evidencia->url_archivo && ! str_starts_with($evidencia->url_archivo, 'http')) {
            Storage::disk('public')->delete($evidencia->url_archivo);
        }

        $evidencia->delete();

        return response()->json([
            'success' => true,
            'message' => 'Evidencia eliminada',
        ]);
    }
}
