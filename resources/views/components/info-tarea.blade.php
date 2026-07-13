@props(['tarea', 'oficinas', 'solicitantes', 'practicantes'])

@php
$activos = $tarea->asignaciones->where('activa', true);
$estadoClasses = match($tarea->estado) {
    'finalizado' => 'bg-green-600 text-white',
    'cancelado' => 'bg-red-600 text-white',
    default => 'bg-gray-200 text-gray-700',
};
$prioridadClasses = match($tarea->prioridad) {
    'critica' => 'bg-red-800 text-white',
    'alta' => 'bg-red-600 text-white',
    'media' => 'bg-yellow-500 text-white',
    'baja' => 'bg-green-600 text-white',
    default => 'bg-gray-300 text-gray-700',
};
$estadoLabel = match($tarea->estado) {
    'pendiente' => 'Pendiente',
    'asignado' => 'Asignado',
    'en_proceso' => 'En Proceso',
    'observado' => 'Observado',
    'finalizado' => 'Finalizado',
    'cancelado' => 'Cancelado',
    default => $tarea->estado,
};
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-900">Información General</h3>
    </div>

    <div id="view-mode">
    <div class="p-6">
        <form id="edit-form" action="/tareas/{{ $tarea->id }}" method="POST" style="display:none">
            @csrf
            @method('PUT')
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Código</label>
                <p class="mt-1 text-sm font-medium text-gray-900">{{ $tarea->codigo }}</p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Título</label>
                <p class="view-field text-sm font-medium text-gray-900">{{ $tarea->titulo }}</p>
                <input form="edit-form" type="text" name="titulo" value="{{ $tarea->titulo }}" required class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo de Soporte</label>
                <p class="view-field text-sm font-medium text-gray-900">{{ ucfirst($tarea->tipo_soporte) }}</p>
                <select form="edit-form" name="tipo_soporte" required class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="hardware" @selected($tarea->tipo_soporte == 'hardware')>Hardware</option>
                    <option value="software" @selected($tarea->tipo_soporte == 'software')>Software</option>
                    <option value="red" @selected($tarea->tipo_soporte == 'red')>Red</option>
                    <option value="impresion" @selected($tarea->tipo_soporte == 'impresion')>Impresión</option>
                    <option value="otro" @selected($tarea->tipo_soporte == 'otro')>Otro</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Prioridad</label>
                <span class="view-field mt-1 inline-block px-3 py-0.5 rounded-full text-xs font-bold {{ $prioridadClasses }}">{{ strtoupper($tarea->prioridad) }}</span>
                <select form="edit-form" name="prioridad" required class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="baja" @selected($tarea->prioridad == 'baja')>Baja</option>
                    <option value="media" @selected($tarea->prioridad == 'media')>Media</option>
                    <option value="alta" @selected($tarea->prioridad == 'alta')>Alta</option>
                    <option value="critica" @selected($tarea->prioridad == 'critica')>Crítica</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Estado</label>
                <span class="view-field mt-1 inline-block px-3 py-0.5 rounded-full text-xs font-bold {{ $estadoClasses }}">{{ $estadoLabel }}</span>
                <select form="edit-form" name="estado" required class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="pendiente" @selected($tarea->estado == 'pendiente')>Pendiente</option>
                    <option value="asignado" @selected($tarea->estado == 'asignado')>Asignado</option>
                    <option value="en_proceso" @selected($tarea->estado == 'en_proceso')>En Proceso</option>
                    <option value="finalizado" @selected($tarea->estado == 'finalizado')>Finalizado</option>
                    <option value="observado" @selected($tarea->estado == 'observado')>Observado</option>
                    <option value="cancelado" @selected($tarea->estado == 'cancelado')>Cancelado</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Ubicación</label>
                <p class="view-field text-sm font-medium text-gray-900">{{ $tarea->ubicacion_detalle ?? '—' }}</p>
                <input form="edit-form" type="text" name="ubicacion_detalle" value="{{ $tarea->ubicacion_detalle }}" class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Solicitante</label>
                <p class="view-field text-sm font-medium text-gray-900">{{ $tarea->solicitante->nombres ?? '—' }} {{ $tarea->solicitante->apellidos ?? '' }}</p>
                <select form="edit-form" name="solicitante_id" required class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($solicitantes as $usuario)
                    <option value="{{ $usuario->id }}" @selected($tarea->solicitante_id == $usuario->id)>{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Oficina</label>
                <p class="view-field text-sm font-medium text-gray-900">{{ $tarea->oficina->nombre ?? '—' }}</p>
                <select form="edit-form" name="oficina_id" class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccionar...</option>
                    @foreach($oficinas as $oficina)
                    <option value="{{ $oficina->id }}" @selected($tarea->oficina_id == $oficina->id)>{{ $oficina->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Asignado a <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
</svg>
</label>
                @if(auth()->user()->rol === 'jefe' && in_array($tarea->estado, ['pendiente', 'asignado', 'en_proceso']))
                <button type="button" id="asignacion-trigger" onclick="document.getElementById('asignacion-panel').classList.toggle('hidden'); this.classList.toggle('hidden')" class="text-left text-[11px] text-green-600 hover:text-green-800 cursor-pointer">
                    @if($activos->count())
                        @foreach($activos as $asignacion)
                        {{ $asignacion->practicante->nombres ?? '—' }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    @else
                    <span class="text-gray-400">{{ $tarea->practicanteAsignado->nombres ?? 'Sin asignar' }} {{ $tarea->practicanteAsignado->apellidos ?? '' }}</span>
                    @endif
                </button>
                <form id="asignacion-panel" action="/tareas/{{ $tarea->id }}/asignar" method="POST" class="hidden pt-0.5">
                    @csrf
                    <div class="space-y-0.5 max-h-24 overflow-y-auto">
                        @foreach($practicantes as $p)
                        <label class="flex items-center gap-1 px-1 py-0.5 rounded hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="practicante_ids[]" value="{{ $p->id }}" @if($tarea->asignaciones->where('activa', true)->contains('practicante_id', $p->id)) checked @endif class="rounded border-gray-300 text-blue-600 w-2 h-2">
                            <span class="text-[10px] text-gray-700 leading-tight">{{ $p->nombres }} {{ $p->apellidos }}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="flex gap-0.5 mt-1 pt-0.5 border-t border-gray-100">
                        <button type="submit" class="flex-1 px-1 py-0.5 bg-blue-600 text-white rounded text-[9px] font-medium hover:bg-blue-700 transition-colors leading-tight">Guardar</button>
                        <button type="button" onclick="document.getElementById('asignacion-panel').classList.add('hidden'); document.getElementById('asignacion-trigger').classList.remove('hidden')" class="px-1 py-0.5 bg-white border border-gray-200 text-gray-500 rounded text-[9px] font-medium hover:bg-gray-50 transition-colors leading-tight">Cancelar</button>
                    </div>
                </form>
                @else
                <div class="text-[11px]">
                    @if($activos->count())
                        @foreach($activos as $asignacion)
                        <span class="text-green-600">{{ $asignacion->practicante->nombres ?? '—' }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    @else
                        <span class="text-gray-400">{{ $tarea->practicanteAsignado->nombres ?? '—' }} {{ $tarea->practicanteAsignado->apellidos ?? '' }}</span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Descripción</label>
            <p class="view-field mt-1 text-sm text-gray-700 bg-gray-50 rounded-lg p-4 border border-gray-100">{{ $tarea->descripcion }}</p>
            <textarea form="edit-form" name="descripcion" required class="edit-field hidden mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3">{{ $tarea->descripcion }}</textarea>
        </div>

        <div class="mt-6 pt-5 border-t border-gray-100 flex flex-wrap gap-2 items-center">
            @if(in_array(auth()->user()->rol, ['jefe', 'practicante']))
            <button type="button" id="btn-edit" onclick="toggleEdit()" class="view-action inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </button>
            @endif

            <button type="submit" form="edit-form" id="btn-save" class="edit-action hidden inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Guardar
            </button>
            <button type="button" id="btn-cancel-edit" onclick="toggleEdit()" class="edit-action hidden inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                Cancelar
            </button>

            @if($tarea->estado == 'asignado' && $tarea->asignaciones->where('activa', true)->contains('practicante_id', auth()->id()) && auth()->user()->rol === 'practicante')
            <form action="/tareas/{{ $tarea->id }}/aceptar" method="POST" class="inline view-action">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Aceptar Tarea
                </button>
            </form>
            @endif

            @if(in_array($tarea->estado, ['en_proceso']) && auth()->user()->rol === 'practicante')
            <a href="/tareas/{{ $tarea->id }}/atenciones/create" class="view-action inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Finalizar
            </a>
            @endif

            @if(in_array($tarea->estado, ['pendiente', 'asignado', 'en_proceso']) && auth()->user()->rol === 'jefe')
            <form action="/tareas/{{ $tarea->id }}/cancelar" method="POST" class="inline view-action" onsubmit="return confirm('¿Cancelar tarea?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-red-300 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Cancelar
                </button>
            </form>
            @endif
        </div>
    </div>
    </div>
</div>

<script>
function toggleEdit() {
    document.querySelectorAll('.view-field').forEach(el => el.classList.toggle('hidden'));
    document.querySelectorAll('.edit-field').forEach(el => el.classList.toggle('hidden'));
    document.querySelectorAll('.view-action').forEach(el => el.classList.toggle('hidden'));
    document.querySelectorAll('.edit-action').forEach(el => el.classList.toggle('hidden'));
}
</script>
