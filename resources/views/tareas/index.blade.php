<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tareas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="/tareas/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Nueva Tarea</a>

                <table class="w-full mt-4" x-data>
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Código</th>
                            <th class="text-left py-2">Título</th>
                            <th class="text-left py-2">Tipo Soporte</th>
                            <th class="text-left py-2">Prioridad</th>
                            <th class="text-left py-2">Estado</th>
                            <th class="text-left py-2">Solicitante</th>
                            <th class="text-left py-2">Oficina</th>
                             <th class="text-left py-2">Técnico</th>
                            <th class="text-left py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tareas as $tarea)
                        <tr class="border-b">
                            <td class="py-2">{{ $tarea->codigo }}</td>
                            <td class="py-2">{{ $tarea->titulo }}</td>
                            <td class="py-2">{{ $tarea->tipo_soporte }}</td>
                            <td class="py-2">{{ $tarea->prioridad }}</td>
                            <td class="py-2">{{ $tarea->estado }}</td>
                            <td class="py-2">{{ $tarea->solicitante->nombres ?? '—' }}</td>
                            <td class="py-2">{{ $tarea->oficina->nombre ?? '—' }}</td>
                            <td class="py-2">{{ $tarea->practicanteAsignado->nombres ?? '—' }}</td>
                            <td class="py-2">
                                <a href="/tareas/{{ $tarea->id }}" class="text-green-600">Ver</a>
                                @if(auth()->user()->rol === 'jefe')
                                <a href="/tareas/{{ $tarea->id }}/edit" class="text-blue-600 ml-2">Editar</a>
                                <button type="button" @click="$dispatch('show-confirm', { title: 'Eliminar tarea', message: '¿Estás seguro de eliminar esta tarea?', confirmText: 'Eliminar', confirmColor: 'bg-red-600 hover:bg-red-700', formAction: '/tareas/{{ $tarea->id }}', formMethod: 'DELETE' })" class="text-red-600 ml-2">Eliminar</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
