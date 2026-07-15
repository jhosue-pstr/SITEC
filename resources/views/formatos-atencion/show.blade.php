<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formato de Atención — {{ $formatoAtencion->tarea->codigo ?? '' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Datos del Solicitante --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Datos del Solicitante</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombres</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->nombres_solicitante }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Apellidos</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->apellidos_solicitante }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">DNI</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->dni_solicitante ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Teléfono</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->telefono_movil ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Régimen Laboral</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->regimen_laboral ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Cargo</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->cargo ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Unidad/Organización</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->unidad_organizacion ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detalle de Atención --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Detalle de Atención</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo de Soporte</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ ucfirst($formatoAtencion->tipo_soporte_informatico) }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Responsable</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->nombre_responsable ?? $formatoAtencion->responsable->nombres ?? '—' }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Reporte del Usuario</label>
                        <p class="mt-1 text-sm text-gray-700 bg-gray-50 rounded-lg p-4 border border-gray-100">{{ $formatoAtencion->reporte_usuario }}</p>
                    </div>
                    @if($formatoAtencion->diagnostico_tecnico)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico Técnico</label>
                        <p class="mt-1 text-sm text-gray-700 bg-gray-50 rounded-lg p-4 border border-gray-100">{{ $formatoAtencion->diagnostico_tecnico }}</p>
                    </div>
                    @endif
                    @if($formatoAtencion->observaciones)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                        <p class="mt-1 text-sm text-gray-700 bg-gray-50 rounded-lg p-4 border border-gray-100">{{ $formatoAtencion->observaciones }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Fechas --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Fechas</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha Atención</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->fecha_atencion ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Hora Atención</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->hora_atencion ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha Entrega</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->fecha_entrega ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Hora Entrega</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $formatoAtencion->hora_entrega ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Firmas --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Firmas</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        {{-- Firma Responsable --}}
                        <div data-signature-pad data-tipo="responsable" data-formato-id="{{ $formatoAtencion->id }}">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Firma del Responsable del Procedimiento</label>
                            <div data-preview>
                                @if($formatoAtencion->firma_responsable_url)
                                    <img src="{{ asset('storage/' . $formatoAtencion->firma_responsable_url) }}" alt="Firma responsable" class="max-h-24 mx-auto border border-gray-200 rounded-lg">
                                @else
                                    <div data-form>
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white">
                                            <canvas class="w-full" style="height: 150px;"></canvas>
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            <button type="button" data-clear class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                                                Limpiar
                                            </button>
                                            <button type="button" data-save class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Firmar
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Firma Solicitante --}}
                        <div data-signature-pad data-tipo="solicitante" data-formato-id="{{ $formatoAtencion->id }}">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Firma del Solicitante</label>
                            <div data-preview>
                                @if($formatoAtencion->firma_solicitante_url)
                                    <img src="{{ asset('storage/' . $formatoAtencion->firma_solicitante_url) }}" alt="Firma solicitante" class="max-h-24 mx-auto border border-gray-200 rounded-lg">
                                @else
                                    <div data-form>
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white">
                                            <canvas class="w-full" style="height: 150px;"></canvas>
                                        </div>
                                        <div class="flex gap-2 mt-2">
                                            <button type="button" data-clear class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                                                Limpiar
                                            </button>
                                            <button type="button" data-save class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Firmar
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center justify-end gap-3 pb-8">
                <a href="/formatos-atencion/{{ $formatoAtencion->id }}/pdf" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Descargar PDF
                </a>
                <a href="/formatos-atencion/{{ $formatoAtencion->id }}/edit" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Editar
                </a>
                <a href="/tareas/{{ $formatoAtencion->tarea_id }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Ver Tarea
                </a>
            </div>

        </div>
    </div>
</x-app-layout>