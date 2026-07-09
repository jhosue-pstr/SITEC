<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Equipos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="/equipos/create" class="bg-blue-500 text-black px-4 py-2 rounded mb-4 inline-block">Nuevo Equipo</a>

                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Tipo</th>
                            <th class="text-left py-2">Código Patrimonial</th>
                            <th class="text-left py-2">N° Serie</th>
                            <th class="text-left py-2">Marca</th>
                            <th class="text-left py-2">Modelo</th>
                            <th class="text-left py-2">Oficina</th>
                            <th class="text-left py-2">Activo</th>
                            <th class="text-left py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                        <tr class="border-b">
                            <td class="py-2">{{ $equipo->tipo_equipo }}</td>
                            <td class="py-2">{{ $equipo->codigo_patrimonial }}</td>
                            <td class="py-2">{{ $equipo->numero_serie }}</td>
                            <td class="py-2">{{ $equipo->marca }}</td>
                            <td class="py-2">{{ $equipo->modelo }}</td>
                            <td class="py-2">{{ $equipo->oficina->nombre ?? '—' }}</td>
                            <td class="py-2">{{ $equipo->activo ? 'Sí' : 'No' }}</td>
                            <td class="py-2">
                                <a href="/equipos/{{ $equipo->id }}/edit" class="text-blue-600">Editar</a>
                                <form action="/equipos/{{ $equipo->id }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 ml-2">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
