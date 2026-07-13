<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Tarea
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/tareas" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Código</label>
                        <input type="text" name="codigo" required class="w-full border rounded px-3 py-2 mt-1" placeholder="Ej: T-001">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Título</label>
                        <input type="text" name="titulo" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Descripción</label>
                        <textarea name="descripcion" required class="w-full border rounded px-3 py-2 mt-1" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Soporte</label>
                        <select name="tipo_soporte" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="red">Red</option>
                            <option value="impresion">Impresión</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Prioridad</label>
                        <select name="prioridad" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="baja">Baja</option>
                            <option value="media" selected>Media</option>
                            <option value="alta">Alta</option>
                            <option value="critica">Crítica</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Ubicación Detalle</label>
                        <input type="text" name="ubicacion_detalle" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Solicitante</label>
                        <select name="solicitante_id" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($solicitantes as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                            @endforeach
                        </select>
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
                        <label class="block text-gray-700">Técnico Asignado</label>
                        <select name="practicante_asignado_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($practicantes as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                    <a href="/tareas" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
