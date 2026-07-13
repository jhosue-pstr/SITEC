@props(['tarea'])

@if($tarea->atencion)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-900">Atención</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico</label>
                <p class="mt-1 text-sm text-gray-700">{{ $tarea->atencion->diagnostico ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tiempo de Atención</label>
                <p class="mt-1 text-sm font-medium text-gray-900">{{ $tarea->atencion->tiempo_atencion_minutos ?? '—' }} min</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Actividades Realizadas</label>
                <p class="mt-1 text-sm text-gray-700">{{ $tarea->atencion->actividades_realizadas ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Solución Aplicada</label>
                <p class="mt-1 text-sm text-gray-700">{{ $tarea->atencion->solucion_aplicada ?? '—' }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                <p class="mt-1 text-sm text-gray-700">{{ $tarea->atencion->observaciones ?? '—' }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="/atenciones/{{ $tarea->atencion->id }}/edit" class="inline-flex items-center gap-1.5 text-sm text-green-600 hover:text-green-800 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar Atención
            </a>
        </div>
    </div>
</div>
@endif
