<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Tarea
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/tareas/{{ $tarea->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Código</label>
                        <input type="text" name="codigo" value="{{ $tarea->codigo }}" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Título</label>
                        <input type="text" name="titulo" value="{{ $tarea->titulo }}" required class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Descripción</label>
                        <textarea name="descripcion" required class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $tarea->descripcion }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Soporte</label>
                        <select name="tipo_soporte" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="hardware" @selected($tarea->tipo_soporte == 'hardware')>Hardware</option>
                            <option value="software" @selected($tarea->tipo_soporte == 'software')>Software</option>
                            <option value="red" @selected($tarea->tipo_soporte == 'red')>Red</option>
                            <option value="impresion" @selected($tarea->tipo_soporte == 'impresion')>Impresión</option>
                            <option value="otro" @selected($tarea->tipo_soporte == 'otro')>Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Prioridad</label>
                        <select name="prioridad" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="baja" @selected($tarea->prioridad == 'baja')>Baja</option>
                            <option value="media" @selected($tarea->prioridad == 'media')>Media</option>
                            <option value="alta" @selected($tarea->prioridad == 'alta')>Alta</option>
                            <option value="critica" @selected($tarea->prioridad == 'critica')>Crítica</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Estado</label>
                        <select name="estado" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="pendiente" @selected($tarea->estado == 'pendiente')>Pendiente</option>
                            <option value="asignado" @selected($tarea->estado == 'asignado')>Asignado</option>
                            <option value="en_proceso" @selected($tarea->estado == 'en_proceso')>En Proceso</option>
                            <option value="finalizado" @selected($tarea->estado == 'finalizado')>Finalizado</option>
                            <option value="observado" @selected($tarea->estado == 'observado')>Observado</option>
                            <option value="cancelado" @selected($tarea->estado == 'cancelado')>Cancelado</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Ubicación Detalle</label>
                        <input type="text" name="ubicacion_detalle" value="{{ $tarea->ubicacion_detalle }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Solicitante</label>
                        <select name="solicitante_id" required class="w-full border rounded px-3 py-2 mt-1">
                            @foreach($solicitantes as $usuario)
                                <option value="{{ $usuario->id }}" @selected($tarea->solicitante_id == $usuario->id)>{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Oficina</label>
                        <select name="oficina_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($oficinas as $oficina)
                                <option value="{{ $oficina->id }}" @selected($tarea->oficina_id == $oficina->id)>{{ $oficina->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Practicante Asignado</label>
                        <select name="practicante_asignado_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($practicantes as $usuario)
                                <option value="{{ $usuario->id }}" @selected($tarea->practicante_asignado_id == $usuario->id)>{{ $usuario->nombres }} {{ $usuario->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    <a href="/tareas" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
