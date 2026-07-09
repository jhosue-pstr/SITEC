<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Formato de Atención
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/formatos-atencion/{{ $formatoAtencion->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Equipo</label>
                        <select name="equipo_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}" @selected($formatoAtencion->equipo_id == $equipo->id)>{{ $equipo->tipo_equipo }} - {{ $equipo->codigo_patrimonial }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Datos del Solicitante</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Nombres</label>
                            <input type="text" name="nombres_solicitante" value="{{ $formatoAtencion->nombres_solicitante }}" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Apellidos</label>
                            <input type="text" name="apellidos_solicitante" value="{{ $formatoAtencion->apellidos_solicitante }}" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">DNI</label>
                            <input type="text" name="dni_solicitante" value="{{ $formatoAtencion->dni_solicitante }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Teléfono Móvil</label>
                            <input type="text" name="telefono_movil" value="{{ $formatoAtencion->telefono_movil }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Régimen Laboral</label>
                            <select name="regimen_laboral" class="w-full border rounded px-3 py-2 mt-1">
                                <option value="">Seleccionar...</option>
                                <option value="CAS" @selected($formatoAtencion->regimen_laboral == 'CAS')>CAS</option>
                                <option value="DL 276" @selected($formatoAtencion->regimen_laboral == 'DL 276')>DL 276</option>
                                <option value="DL 728" @selected($formatoAtencion->regimen_laboral == 'DL 728')>DL 728</option>
                                <option value="DL 1057" @selected($formatoAtencion->regimen_laboral == 'DL 1057')>DL 1057</option>
                                <option value="otros" @selected($formatoAtencion->regimen_laboral == 'otros')>Otros</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Cargo</label>
                            <input type="text" name="cargo" value="{{ $formatoAtencion->cargo }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Unidad/Organización</label>
                            <input type="text" name="unidad_organizacion" value="{{ $formatoAtencion->unidad_organizacion }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Detalle de Atención</h3>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Soporte Informático</label>
                        <select name="tipo_soporte_informatico" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="hardware" @selected($formatoAtencion->tipo_soporte_informatico == 'hardware')>Hardware</option>
                            <option value="software" @selected($formatoAtencion->tipo_soporte_informatico == 'software')>Software</option>
                            <option value="red" @selected($formatoAtencion->tipo_soporte_informatico == 'red')>Red</option>
                            <option value="impresion" @selected($formatoAtencion->tipo_soporte_informatico == 'impresion')>Impresión</option>
                            <option value="otro" @selected($formatoAtencion->tipo_soporte_informatico == 'otro')>Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Reporte del Usuario</label>
                        <textarea name="reporte_usuario" required class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $formatoAtencion->reporte_usuario }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Diagnóstico Técnico</label>
                        <textarea name="diagnostico_tecnico" class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $formatoAtencion->diagnostico_tecnico }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded px-3 py-2 mt-1" rows="2">{{ $formatoAtencion->observaciones }}</textarea>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Fechas</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Fecha de Atención</label>
                            <input type="date" name="fecha_atencion" value="{{ $formatoAtencion->fecha_atencion }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Hora de Atención</label>
                            <input type="time" name="hora_atencion" value="{{ $formatoAtencion->hora_atencion }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Fecha de Entrega</label>
                            <input type="date" name="fecha_entrega" value="{{ $formatoAtencion->fecha_entrega }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Hora de Entrega</label>
                            <input type="time" name="hora_entrega" value="{{ $formatoAtencion->hora_entrega }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    <a href="/formatos-atencion" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
