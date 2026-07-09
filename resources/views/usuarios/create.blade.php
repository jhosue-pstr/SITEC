<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/usuarios" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nombres</label>
                        <input type="text" name="nombres" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Apellidos</label>
                        <input type="text" name="apellidos" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Correo</label>
                        <input type="email" name="correo" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Rol</label>
                        <select name="rol" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            <option value="jefe">Jefe</option>
                            <option value="practicante">Practicante</option>
                            <option value="solicitante">Solicitante</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Contraseña</label>
                        <input type="password" name="password" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                    <a href="/usuarios" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
