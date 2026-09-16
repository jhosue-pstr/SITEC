<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\FormatoAtencion;
use App\Models\Tarea;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormatoAtencionController extends Controller
{
    public function index()
    {
        $formatos = FormatoAtencion::with('tarea', 'equipo', 'responsable')->get();

        return view('formatos-atencion.index', compact('formatos'));
    }

    public function create(Tarea $tarea)
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

        return view('formatos-atencion.create', compact('tarea', 'equipos', 'defaults'));
    }

    public function store(Request $request, Tarea $tarea)
    {
        $disk = Storage::disk(config('filesystems.default'));
        $data = $request->except(['firma_responsable_data', 'firma_solicitante_data']);
        $data['responsable_atencion_id'] = auth()->id();

        $formato = FormatoAtencion::updateOrCreate(
            ['tarea_id' => $tarea->id],
            $data
        );

        foreach (['responsable', 'solicitante'] as $tipo) {
            $firmaData = $request->input("firma_{$tipo}_data");
            if ($firmaData) {
                $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $firmaData));
                $filename = 'firmas/'.$tarea->codigo.'_'.$tipo.'_'.time().'.png';
                $disk->put($filename, $imageData);
                $campo = "firma_{$tipo}_url";
                $formato->update([$campo => $filename]);
            }
        }

        $this->generarPdf($formato);

        return redirect("/formatos-atencion/{$formato->id}")->with('toast_success', 'Formato de atención registrado');
    }

    public function show(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->load('tarea', 'equipo', 'responsable');

        return view('formatos-atencion.show', compact('formatoAtencion'));
    }

    public function edit(FormatoAtencion $formatoAtencion)
    {
        $equipos = Equipo::all();

        return view('formatos-atencion.edit', compact('formatoAtencion', 'equipos'));
    }

    public function update(Request $request, FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->update($request->all());
        $this->generarPdf($formatoAtencion);

        return redirect('/formatos-atencion')->with('toast_success', 'Formato actualizado');
    }

    public function destroy(FormatoAtencion $formatoAtencion)
    {
        if ($formatoAtencion->pdf_url) {
            Storage::disk(config('filesystems.default'))->delete($formatoAtencion->pdf_url);
        }
        $formatoAtencion->delete();

        return redirect('/formatos-atencion')->with('toast_success', 'Formato eliminado');
    }

    public function pdf(FormatoAtencion $formatoAtencion)
    {
        $formatoAtencion->load('tarea', 'equipo', 'responsable');

        $disk = Storage::disk(config('filesystems.default'));
        if ($formatoAtencion->pdf_url && $disk->exists($formatoAtencion->pdf_url)) {
            return $disk->download($formatoAtencion->pdf_url, 'formato_atencion_'.$formatoAtencion->tarea->codigo.'.pdf');
        }

        $this->generarPdf($formatoAtencion);

        if ($formatoAtencion->pdf_url && $disk->exists($formatoAtencion->pdf_url)) {
            return $disk->download($formatoAtencion->pdf_url, 'formato_atencion_'.$formatoAtencion->tarea->codigo.'.pdf');
        }

        return back()->with('toast_error', 'Error al generar el PDF');
    }

    public function firma(Request $request, FormatoAtencion $formatoAtencion)
    {
        $request->validate([
            'firma' => 'required|string',
            'tipo' => 'required|in:responsable,solicitante',
        ]);

        $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $request->firma));

        $filename = 'firmas/'.$formatoAtencion->tarea->codigo.'_'.$request->tipo.'_'.time().'.png';
        Storage::disk(config('filesystems.default'))->put($filename, $imageData);

        $campo = $request->tipo === 'responsable' ? 'firma_responsable_url' : 'firma_solicitante_url';
        $formatoAtencion->update([$campo => $filename]);

        $this->generarPdf($formatoAtencion);

        return response()->json([
            'success' => true,
            'url' => Storage::disk(config('filesystems.default'))->url($filename),
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
        $destino = tempnam(sys_get_temp_dir(), 'sitec_pdf_');
        $pdf->save($destino);
        $disk = Storage::disk(config('filesystems.default'));
        $disk->put($filename, fopen($destino, 'r'));
        unlink($destino);

        $formato->update(['pdf_url' => $filename]);
    }
}
