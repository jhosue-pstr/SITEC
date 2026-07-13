<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formatos de Atención
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full mt-4" x-data>
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Tarea</th>
                            <th class="text-left py-2">Solicitante</th>
                            <th class="text-left py-2">DNI</th>
                            <th class="text-left py-2">Estado</th>
                            <th class="text-left py-2">Fecha</th>
                            <th class="text-left py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formatos as $formato)
                        <tr class="border-b">
                            <td class="py-2">{{ $formato->tarea->codigo ?? '—' }}</td>
                            <td class="py-2">{{ $formato->nombres_solicitante }} {{ $formato->apellidos_solicitante }}</td>
                            <td class="py-2">{{ $formato->dni_solicitante ?? '—' }}</td>
                            <td class="py-2">{{ $formato->estado_formato }}</td>
                            <td class="py-2">{{ $formato->created_at->format('d/m/Y') }}</td>
                            <td class="py-2">
                                <a href="/formatos-atencion/{{ $formato->id }}" class="text-blue-600">Ver</a>
                                <a href="/formatos-atencion/{{ $formato->id }}/edit" class="text-blue-600 ml-2">Editar</a>
                                <button type="button" @click="$dispatch('show-confirm', { title: 'Eliminar formato', message: '¿Estás seguro de eliminar este formato de atención?', confirmText: 'Eliminar', confirmColor: 'bg-red-600 hover:bg-red-700', formAction: '/formatos-atencion/{{ $formato->id }}', formMethod: 'DELETE' })" class="text-red-600 ml-2">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
