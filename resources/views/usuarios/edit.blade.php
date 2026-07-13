<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/usuarios/{{ $usuario->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nombres</label>
                        <input type="text" name="nombres" value="{{ $usuario->nombres }}" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Apellidos</label>
                        <input type="text" name="apellidos" value="{{ $usuario->apellidos }}" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Correo</label>
                        <input type="email" name="correo" value="{{ $usuario->correo }}" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="{{ $usuario->telefono }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Rol</label>
                        <select name="rol" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="jefe" @selected($usuario->rol == 'jefe')>Jefe</option>
                            <option value="practicante" @selected($usuario->rol == 'practicante')>Técnico</option>
                            <option value="solicitante" @selected($usuario->rol == 'solicitante')>Solicitante</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Activo</label>
                        <select name="activo" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="1" @selected($usuario->activo)>Sí</option>
                            <option value="0" @selected(!$usuario->activo)>No</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Nueva Contraseña <span class="text-gray-400 text-sm">(dejar vacío para mantener)</span></label>
                        <input type="password" name="password" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    <a href="/usuarios" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
