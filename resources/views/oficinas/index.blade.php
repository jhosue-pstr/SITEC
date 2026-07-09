<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Oficinas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="/oficinas/create" class="bg-blue-500 text-black px-4 py-2 rounded mb-4 inline-block">Nueva Oficina</a>

                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Nombre</th>
                            <th class="text-left py-2">Ubicación</th>
                            <th class="text-left py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oficinas as $oficina)
                        <tr class="border-b">
                            <td class="py-2">{{ $oficina->nombre }}</td>
                            <td class="py-2">{{ $oficina->ubicacion }}</td>
                            <td class="py-2">
                                <a href="/oficinas/{{ $oficina->id }}/edit" class="text-blue-600">Editar</a>
                                <form action="/oficinas/{{ $oficina->id }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
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
