<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar Formato de Atención
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-gray-600">Tarea: <strong>{{ $tarea->codigo }}</strong> - {{ $tarea->titulo }}</p>

                <form action="/tareas/{{ $tarea->id }}/formatos-atencion" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Equipo</label>
                        <select name="equipo_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}">{{ $equipo->tipo_equipo }} - {{ $equipo->codigo_patrimonial }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Datos del Solicitante</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Nombres</label>
                            <input type="text" name="nombres_solicitante" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Apellidos</label>
                            <input type="text" name="apellidos_solicitante" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">DNI</label>
                            <input type="text" name="dni_solicitante" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Teléfono Móvil</label>
                            <input type="text" name="telefono_movil" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Régimen Laboral</label>
                            <select name="regimen_laboral" class="w-full border rounded px-3 py-2 mt-1">
                                <option value="">Seleccionar...</option>
                                <option value="CAS">CAS</option>
                                <option value="DL 276">DL 276</option>
                                <option value="DL 728">DL 728</option>
                                <option value="DL 1057">DL 1057</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Cargo</label>
                            <input type="text" name="cargo" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Unidad/Organización</label>
                            <input type="text" name="unidad_organizacion" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Detalle de Atención</h3>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Soporte Informático</label>
                        <select name="tipo_soporte_informatico" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="red">Red</option>
                            <option value="impresion">Impresión</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Reporte del Usuario</label>
                        <textarea name="reporte_usuario" required class="w-full border rounded px-3 py-2 mt-1" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Diagnóstico Técnico</label>
                        <textarea name="diagnostico_tecnico" class="w-full border rounded px-3 py-2 mt-1" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded px-3 py-2 mt-1" rows="2"></textarea>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Fechas</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Fecha de Atención</label>
                            <input type="date" name="fecha_atencion" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Hora de Atención</label>
                            <input type="time" name="hora_atencion" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Fecha de Entrega</label>
                            <input type="date" name="fecha_entrega" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Hora de Entrega</label>
                            <input type="time" name="hora_entrega" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Formato</button>
                    <a href="/tareas/{{ $tarea->id }}" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
