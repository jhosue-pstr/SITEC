<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\FormatoAtencion;
use App\Models\Tarea;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormatoAtencionApiController extends Controller
{
    public function index()
    {
        $formatos = FormatoAtencion::with('tarea', 'equipo', 'responsable')->get();

        return response()->json([
            'success' => true,
            'data' => $formatos,
        ]);
    }

    public function show(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->load('tarea', 'equipo', 'responsable');

        return response()->json([
            'success' => true,
            'data' => $formatoAtencion,
        ]);
    }

    public function defaults(Tarea $tarea)
    {
        $tarea->load(['solicitante', 'atencion', 'practicanteAsignado']);
        $equipos = Equipo::all();

        $defaults = [
            'nombres_solicitante' => $tarea->solicitante->nombres ?? '',
            'apellidos_solicitante' => $tarea->solicitante->apellidos ?? '',
            'telefono_movil' => $tarea->solicitante->telefono ?? '',
            'tipo_soporte_informatico' => $tarea->tipo_soporte ?? '',
            'reporte_usuario' => $tarea->descripcion ?? '',
            'diagnostico_tecnico' => $tarea->atencion->diagnostico ?? '',
            'observaciones' => $tarea->atencion->observaciones ?? '',
            'fecha_atencion' => $tarea->atencion->fecha_atencion?->format('Y-m-d') ?? '',
            'hora_atencion' => $tarea->atencion->fecha_atencion?->format('H:i') ?? '',
            'fecha_entrega' => $tarea->fecha_finalizacion?->format('Y-m-d') ?? now()->format('Y-m-d'),
            'hora_entrega' => now()->format('H:i'),
            'nombre_responsable' => $tarea->practicanteAsignado
                ? trim($tarea->practicanteAsignado->nombres.' '.$tarea->practicanteAsignado->apellidos)
                : '',
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'defaults' => $defaults,
                'equipos' => $equipos,
            ],
        ]);
    }

    public function store(Request $request, Tarea $tarea)
    {
        $data = $request->except(['firma_responsable_data', 'firma_solicitante_data', 'firma_responsable_base64', 'firma_solicitante_base64']);
        $data['responsable_atencion_id'] = $request->user()->id;

        $formato = FormatoAtencion::updateOrCreate(
            ['tarea_id' => $tarea->id],
            $data
        );

        Storage::disk('public')->makeDirectory('firmas');

        foreach (['responsable', 'solicitante'] as $tipo) {
            $firmaData = $request->input("firma_{$tipo}_data") ?? $request->input("firma_{$tipo}_base64");
            if ($firmaData) {
                $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $firmaData));
                $filename = 'firmas/'.$tarea->codigo.'_'.$tipo.'_'.time().'.png';
                file_put_contents(storage_path('app/public/'.$filename), $imageData);
                $campo = "firma_{$tipo}_url";
                $formato->update([$campo => $filename]);
            }
        }

        $this->generarPdf($formato);

        return response()->json([
            'success' => true,
            'data' => $formato->fresh()->load('tarea', 'equipo', 'responsable'),
            'message' => 'Formato de atención registrado',
        ], 201);
    }

    public function update(Request $request, FormatoAtencion $formatoAtencion)
    {
        $data = $request->except(['firma_responsable_data', 'firma_solicitante_data', 'firma_responsable_base64', 'firma_solicitante_base64']);
        $formatoAtencion->update($data);

        Storage::disk('public')->makeDirectory('firmas');

        foreach (['responsable', 'solicitante'] as $tipo) {
            $firmaData = $request->input("firma_{$tipo}_data") ?? $request->input("firma_{$tipo}_base64");
            if ($firmaData) {
                $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $firmaData));
                $filename = 'firmas/'.$formatoAtencion->tarea->codigo.'_'.$tipo.'_'.time().'.png';
                file_put_contents(storage_path('app/public/'.$filename), $imageData);
                $campo = "firma_{$tipo}_url";
                $formatoAtencion->update([$campo => $filename]);
            }
        }

        $this->generarPdf($formatoAtencion);

        return response()->json([
            'success' => true,
            'data' => $formatoAtencion->fresh()->load('tarea', 'equipo', 'responsable'),
            'message' => 'Formato actualizado',
        ]);
    }

    public function destroy(FormatoAtencion $formatoAtencion)
    {
        if ($formatoAtencion->pdf_url) {
            Storage::disk('public')->delete($formatoAtencion->pdf_url);
        }
        $formatoAtencion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Formato eliminado',
        ]);
    }

    public function pdf(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->load('tarea', 'equipo', 'responsable');

        if ($formatoAtencion->pdf_url && Storage::disk('public')->exists($formatoAtencion->pdf_url)) {
            $fullPath = storage_path('app/public/'.$formatoAtencion->pdf_url);

            return response()->download($fullPath, 'formato_atencion_'.$formatoAtencion->tarea->codigo.'.pdf');
        }

        $this->generarPdf($formatoAtencion);

        if ($formatoAtencion->pdf_url && Storage::disk('public')->exists($formatoAtencion->pdf_url)) {
            $fullPath = storage_path('app/public/'.$formatoAtencion->pdf_url);

            return response()->download($fullPath, 'formato_atencion_'.$formatoAtencion->tarea->codigo.'.pdf');
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al generar el PDF',
        ], 500);
    }

    public function firma(Request $request, FormatoAtencion $formatoAtencion)
    {
        $request->validate([
            'firma' => 'required|string',
            'tipo' => 'required|in:responsable,solicitante',
        ]);

        $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $request->firma));

        Storage::disk('public')->makeDirectory('firmas');
        $filename = 'firmas/'.$formatoAtencion->tarea->codigo.'_'.$request->tipo.'_'.time().'.png';
        $path = storage_path('app/public/'.$filename);
        file_put_contents($path, $imageData);

        $campo = $request->tipo === 'responsable' ? 'firma_responsable_url' : 'firma_solicitante_url';
        $formatoAtencion->update([$campo => $filename]);

        $this->generarPdf($formatoAtencion);

        return response()->json([
            'success' => true,
            'data' => [
                'url' => asset('storage/'.$filename),
            ],
        ]);
    }

    private function generarPdf(FormatoAtencion $formato): void
    {
        $formato->load('tarea', 'equipo', 'responsable');

        $html = view('formatos-atencion.pdf', compact('formato'))->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('letter', 'portrait')
            ->setOption('isRemoteEnabled', true);

        $filename = 'formatos_atencion/formato_'.$formato->tarea->codigo.'_'.time().'.pdf';
        $destino = storage_path('app/public/'.$filename);

        Storage::disk('public')->makeDirectory('formatos_atencion');
        $pdf->save($destino);

        $formato->update(['pdf_url' => $filename]);
    }
}
