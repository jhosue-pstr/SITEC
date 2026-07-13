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
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-info-tarea :tarea="$tarea" :oficinas="$oficinas" :solicitantes="$solicitantes" :practicantes="$practicantes" />

            <x-atencion-tarea :tarea="$tarea" />

            <x-evidencias-tarea :tarea="$tarea" />

            <x-comentarios-tarea :tarea="$tarea" />

            <x-formato-atencion-tarea :tarea="$tarea" />

            <x-historial-asignaciones :tarea="$tarea" />

        </div>
    </div>
</x-app-layout>
