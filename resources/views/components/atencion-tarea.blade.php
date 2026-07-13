ha@props(['tarea'])

@if($tarea->atencion)
<div x-data="{ editing: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Atención</h3>
        @if($tarea->estado === 'en_proceso' && auth()->user()->rol === 'practicante')
        <div class="flex items-center gap-2">
            <button type="button" x-show="!editing" @click="editing = true" class="inline-flex items-center gap-1.5 text-sm text-green-600 hover:text-green-800 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </button>
            <button type="button" x-show="editing" @click="editing = false" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 font-medium">
                Cancelar
            </button>
        </div>
        @endif
    </div>
    <div class="p-6">

        {{-- Modo vista --}}
        <div x-show="!editing">
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
        </div>

        {{-- Modo edición --}}
        <div x-show="editing" style="display: none;">
            <form action="/atenciones/{{ $tarea->atencion->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico</label>
                        <textarea name="diagnostico" required rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $tarea->atencion->diagnostico }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tiempo de Atención (minutos)</label>
                        <input type="number" name="tiempo_atencion_minutos" min="0" value="{{ $tarea->atencion->tiempo_atencion_minutos }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Actividades Realizadas</label>
                        <textarea name="actividades_realizadas" rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $tarea->atencion->actividades_realizadas }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Solución Aplicada</label>
                        <textarea name="solucion_aplicada" rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $tarea->atencion->solucion_aplicada }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                        <textarea name="observaciones" rows="2" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $tarea->atencion->observaciones }}</textarea>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-gray-100 flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar
                    </button>
                    <button type="button" @click="editing = false" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endif
