@props(['tarea'])

@if($tarea->estado === 'en_proceso' && !$tarea->atencion && auth()->user()->rol === 'practicante')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-900">Registrar Atención</h3>
    </div>
    <div class="p-6">
        <form action="/tareas/{{ $tarea->id }}/atenciones" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico</label>
                    <textarea name="diagnostico" required rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Describe el diagnóstico del problema..."></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Actividades Realizadas</label>
                    <textarea name="actividades_realizadas" rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="¿Qué actividades se realizaron?"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Solución Aplicada</label>
                    <textarea name="solucion_aplicada" rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="¿Qué solución se aplicó?"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Observaciones adicionales..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tiempo de Atención (minutos)</label>
                    <input type="number" name="tiempo_atencion_minutos" min="0" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 45">
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-gray-100">
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Guardar Atención
                </button>
            </div>
        </form>
    </div>
</div>
@endif
