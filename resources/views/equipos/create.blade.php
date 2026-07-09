<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Equipo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/equipos" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Equipo</label>
                        <select name="tipo_equipo" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            <option value="computadora">Computadora</option>
                            <option value="laptop">Laptop</option>
                            <option value="impresora">Impresora</option>
                            <option value="monitor">Monitor</option>
                            <option value="router">Router</option>
                            <option value="switch">Switch</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Código Patrimonial</label>
                        <input type="text" name="codigo_patrimonial" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Número de Serie</label>
                        <input type="text" name="numero_serie" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Marca</label>
                        <input type="text" name="marca" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Modelo</label>
                        <input type="text" name="modelo" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Oficina</label>
                        <select name="oficina_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($oficinas as $oficina)
                                <option value="{{ $oficina->id }}">{{ $oficina->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Usuario Responsable</label>
                        <select name="usuario_responsable_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                    <a href="/equipos" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
