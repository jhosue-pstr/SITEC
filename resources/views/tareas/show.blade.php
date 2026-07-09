<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tarea: {{ $tarea->codigo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Información General</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-gray-500">Código</dt><dd>{{ $tarea->codigo }}</dd></div>
                    <div><dt class="text-gray-500">Título</dt><dd>{{ $tarea->titulo }}</dd></div>
                    <div><dt class="text-gray-500">Descripción</dt><dd>{{ $tarea->descripcion }}</dd></div>
                    <div><dt class="text-gray-500">Tipo Soporte</dt><dd>{{ $tarea->tipo_soporte }}</dd></div>
                    <div><dt class="text-gray-500">Prioridad</dt><dd>{{ $tarea->prioridad }}</dd></div>
                    <div><dt class="text-gray-500">Estado</dt><dd>{{ $tarea->estado }}</dd></div>
                    <div><dt class="text-gray-500">Ubicación</dt><dd>{{ $tarea->ubicacion_detalle ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Solicitante</dt><dd>{{ $tarea->solicitante->nombres ?? '—' }} {{ $tarea->solicitante->apellidos ?? '' }}</dd></div>
                    <div><dt class="text-gray-500">Oficina</dt><dd>{{ $tarea->oficina->nombre ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Practicante</dt><dd>{{ $tarea->practicanteAsignado->nombres ?? '—' }} {{ $tarea->practicanteAsignado->apellidos ?? '' }}</dd></div>
                </dl>

                <div class="mt-4 space-x-2">
                    <a href="/tareas/{{ $tarea->id }}/edit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Editar</a>

                    @if($tarea->estado == 'pendiente')
                    <form action="/tareas/{{ $tarea->id }}/asignar" method="POST" class="inline">
                        @csrf
                        <select name="practicante_id" required class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                            <option value="">Asignar a...</option>
                            @foreach(\App\Models\Usuario::where('rol', 'practicante')->get() as $p)
                                <option value="{{ $p->id }}">{{ $p->nombres }} {{ $p->apellidos }}</option>
                            @endforeach
                        </select>
                    </form>
                    @endif

                    @if($tarea->estado == 'asignado' && auth()->id() == $tarea->practicante_asignado_id)
                    <form action="/tareas/{{ $tarea->id }}/aceptar" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm">Aceptar Tarea</button>
                    </form>
                    @endif

                    @if(in_array($tarea->estado, ['en_proceso']))
                    <a href="/tareas/{{ $tarea->id }}/atenciones/create" class="bg-green-600 text-white px-3 py-1 rounded text-sm">Finalizar</a>
                    @endif

                    @if(in_array($tarea->estado, ['pendiente', 'asignado', 'en_proceso']))
                    <form action="/tareas/{{ $tarea->id }}/cancelar" method="POST" class="inline" onsubmit="return confirm('¿Cancelar tarea?')">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm">Cancelar</button>
                    </form>
                    @endif
                </div>
            </div>

            @if($tarea->atencion)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Atención</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-gray-500">Diagnóstico</dt><dd>{{ $tarea->atencion->diagnostico ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Actividades</dt><dd>{{ $tarea->atencion->actividades_realizadas ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Solución</dt><dd>{{ $tarea->atencion->solucion_aplicada ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Observaciones</dt><dd>{{ $tarea->atencion->observaciones ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Tiempo (min)</dt><dd>{{ $tarea->atencion->tiempo_atencion_minutos ?? '—' }}</dd></div>
                </dl>
                <a href="/atenciones/{{ $tarea->atencion->id }}/edit" class="text-blue-600 text-sm mt-2 inline-block">Editar Atención</a>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Evidencias</h3>
                @if($tarea->evidencias->count())
                <table class="w-full mb-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Archivo</th>
                            <th class="text-left py-2">Tipo</th>
                            <th class="text-left py-2">Descripción</th>
                            <th class="text-left py-2">Subido por</th>
                            <th class="text-left py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tarea->evidencias as $evidencia)
                        <tr class="border-b">
                            <td class="py-2">{{ $evidencia->nombre_archivo }}</td>
                            <td class="py-2">{{ $evidencia->tipo_evidencia }}</td>
                            <td class="py-2">{{ $evidencia->descripcion ?? '—' }}</td>
                            <td class="py-2">{{ $evidencia->subidoPor->nombres ?? '—' }}</td>
                            <td class="py-2">
                                <form action="/evidencias/{{ $evidencia->id }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar evidencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-gray-500 mb-4">Sin evidencias registradas.</p>
                @endif

                <form action="/tareas/{{ $tarea->id }}/evidencias" method="POST" class="border-t pt-4">
                    @csrf
                    <div class="grid grid-cols-4 gap-2">
                        <input type="text" name="nombre_archivo" placeholder="Nombre archivo" required class="border rounded px-2 py-1 text-sm">
                        <input type="text" name="url_archivo" placeholder="URL archivo" required class="border rounded px-2 py-1 text-sm">
                        <select name="tipo_evidencia" required class="border rounded px-2 py-1 text-sm">
                            <option value="imagen">Imagen</option>
                            <option value="documento">Documento</option>
                            <option value="captura">Captura</option>
                            <option value="otro">Otro</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Agregar</button>
                    </div>
                    <input type="text" name="descripcion" placeholder="Descripción (opcional)" class="w-full border rounded px-2 py-1 text-sm mt-2">
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Comentarios</h3>
                @if($tarea->comentarios->count())
                <div class="space-y-3 mb-4">
                    @foreach($tarea->comentarios as $comentario)
                    <div class="border-b pb-2">
                        <p class="text-sm text-gray-500">{{ $comentario->usuario->nombres ?? '—' }} - {{ $comentario->created_at->format('d/m/Y H:i') }}</p>
                        <p>{{ $comentario->comentario }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 mb-4">Sin comentarios.</p>
                @endif

                <form action="/tareas/{{ $tarea->id }}/comentarios" method="POST" class="border-t pt-4">
                    @csrf
                    <textarea name="comentario" required class="w-full border rounded px-3 py-2 mt-1" rows="2" placeholder="Escribir comentario..."></textarea>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm mt-2">Comentar</button>
                </form>
            </div>

            @if($tarea->formatoAtencion ?? false)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Formato de Atención</h3>
                <a href="/formatos-atencion/{{ $tarea->formatoAtencion->id }}" class="text-blue-600">Ver Formato</a>
            </div>
            @elseif($tarea->atencion)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Formato de Atención</h3>
                <a href="/tareas/{{ $tarea->id }}/formatos-atencion/create" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Generar Formato</a>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Historial de Asignaciones</h3>
                @if($tarea->asignaciones->count())
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Practicante</th>
                            <th class="text-left py-2">Tipo</th>
                            <th class="text-left py-2">Fecha</th>
                            <th class="text-left py-2">Activa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tarea->asignaciones as $asignacion)
                        <tr class="border-b">
                            <td class="py-2">{{ $asignacion->practicante->nombres ?? '—' }}</td>
                            <td class="py-2">{{ $asignacion->tipo_asignacion }}</td>
                            <td class="py-2">{{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}</td>
                            <td class="py-2">{{ $asignacion->activa ? 'Sí' : 'No' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-gray-500">Sin asignaciones.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
