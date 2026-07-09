<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Equipo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/equipos/{{ $equipo->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Equipo</label>
                        <select name="tipo_equipo" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach(['computadora','laptop','impresora','monitor','router','switch','otro'] as $tipo)
                                <option value="{{ $tipo }}" @selected($equipo->tipo_equipo == $tipo)>{{ ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Código Patrimonial</label>
                        <input type="text" name="codigo_patrimonial" value="{{ $equipo->codigo_patrimonial }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Número de Serie</label>
                        <input type="text" name="numero_serie" value="{{ $equipo->numero_serie }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Marca</label>
                        <input type="text" name="marca" value="{{ $equipo->marca }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Modelo</label>
                        <input type="text" name="modelo" value="{{ $equipo->modelo }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Oficina</label>
                        <select name="oficina_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($oficinas as $oficina)
                                <option value="{{ $oficina->id }}" @selected($equipo->oficina_id == $oficina->id)>{{ $oficina->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Usuario Responsable</label>
                        <select name="usuario_responsable_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" @selected($equipo->usuario_responsable_id == $usuario->id)>{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    <a href="/equipos" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
