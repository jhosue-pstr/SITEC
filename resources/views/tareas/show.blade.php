<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-3">
                <a href="{{ route('tareas.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Volver</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $tarea->codigo }}
                </h2>
                @php
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
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $prioridadClasses }}">{{ strtoupper($tarea->prioridad) }}</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $estadoClasses }}">{{ $estadoLabel }}</span>
            </div>
            <div class="flex items-center gap-2" x-data>
                @if($tarea->estado === 'en_proceso' && auth()->user()->rol === 'practicante')
                    <button type="button" @click="$dispatch('show-confirm', { title: 'Finalizar tarea', message: '¿Estás seguro de finalizar esta tarea? Se redirigirá al formato de atención.', confirmText: 'Finalizar', confirmColor: 'bg-green-600 hover:bg-green-700', formAction: '{{ route('tareas.finalizar', $tarea) }}', formMethod: 'POST' })" class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Finalizar tarea
                    </button>
                @endif

                @if(in_array($tarea->estado, ['en_proceso', 'asignado']) && auth()->user()->rol === 'jefe')
                <div class="border-l border-gray-200 pl-2">
                    <button type="button" @click="$dispatch('show-confirm', { title: 'Marcar como observada', message: '¿Estás seguro de marcar esta tarea como observada?', confirmText: 'Observar', confirmColor: 'bg-yellow-500 hover:bg-yellow-600', formAction: '{{ route('tareas.observar', $tarea) }}', formMethod: 'POST' })" class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-500 text-white rounded-lg text-sm font-medium hover:bg-yellow-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Observar
                    </button>
                </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-info-tarea :tarea="$tarea" :oficinas="$oficinas" :solicitantes="$solicitantes" :practicantes="$practicantes" />

            <x-registrar-atencion :tarea="$tarea" />

            <x-atencion-tarea :tarea="$tarea" />

            <x-evidencias-tarea :tarea="$tarea" />

            <x-comentarios-tarea :tarea="$tarea" />

            <x-formato-atencion-tarea :tarea="$tarea" />

            <x-historial-asignaciones :tarea="$tarea" />

        </div>
    </div>
</x-app-layout>
