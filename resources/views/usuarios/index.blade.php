<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="/usuarios/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Nuevo Usuario</a>

                <table class="w-full mt-4" x-data>
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Nombres</th>
                            <th class="text-left py-2">Apellidos</th>
                            <th class="text-left py-2">Correo</th>
                            <th class="text-left py-2">Rol</th>
                            <th class="text-left py-2">Activo</th>
                            <th class="text-left py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr class="border-b">
                            <td class="py-2">{{ $usuario->nombres }}</td>
                            <td class="py-2">{{ $usuario->apellidos }}</td>
                            <td class="py-2">{{ $usuario->correo }}</td>
                            <td class="py-2">{{ $usuario->rol }}</td>
                            <td class="py-2">{{ $usuario->activo ? 'Sí' : 'No' }}</td>
                            <td class="py-2">
                                <a href="/usuarios/{{ $usuario->id }}/edit" class="text-blue-600">Editar</a>
                                <button type="button" @click="$dispatch('show-confirm', { title: 'Eliminar usuario', message: '¿Estás seguro de eliminar este usuario?', confirmText: 'Eliminar', confirmColor: 'bg-red-600 hover:bg-red-700', formAction: '/usuarios/{{ $usuario->id }}', formMethod: 'DELETE' })" class="text-red-600 ml-2">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
