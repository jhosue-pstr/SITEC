<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formato de Atención - {{ $formatoAtencion->tarea->codigo ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Datos del Solicitante</h3>
                <dl class="grid grid-cols-2 gap-4 mb-6">
                    <div><dt class="text-gray-500">Nombres</dt><dd>{{ $formatoAtencion->nombres_solicitante }}</dd></div>
                    <div><dt class="text-gray-500">Apellidos</dt><dd>{{ $formatoAtencion->apellidos_solicitante }}</dd></div>
                    <div><dt class="text-gray-500">DNI</dt><dd>{{ $formatoAtencion->dni_solicitante ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Teléfono</dt><dd>{{ $formatoAtencion->telefono_movil ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Régimen Laboral</dt><dd>{{ $formatoAtencion->regimen_laboral ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Cargo</dt><dd>{{ $formatoAtencion->cargo ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Unidad/Organización</dt><dd>{{ $formatoAtencion->unidad_organizacion ?? '—' }}</dd></div>
                </dl>

                <h3 class="text-lg font-semibold mb-4">Detalle de Atención</h3>
                <dl class="grid grid-cols-2 gap-4 mb-6">
                    <div><dt class="text-gray-500">Tipo Soporte</dt><dd>{{ $formatoAtencion->tipo_soporte_informatico }}</dd></div>
                    <div><dt class="text-gray-500">Reporte del Usuario</dt><dd>{{ $formatoAtencion->reporte_usuario }}</dd></div>
                    <div><dt class="text-gray-500">Diagnóstico Técnico</dt><dd>{{ $formatoAtencion->diagnostico_tecnico ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Observaciones</dt><dd>{{ $formatoAtencion->observaciones ?? '—' }}</dd></div>
                </dl>

                <h3 class="text-lg font-semibold mb-4">Fechas</h3>
                <dl class="grid grid-cols-2 gap-4 mb-6">
                    <div><dt class="text-gray-500">Fecha Atención</dt><dd>{{ $formatoAtencion->fecha_atencion ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Hora Atención</dt><dd>{{ $formatoAtencion->hora_atencion ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Fecha Entrega</dt><dd>{{ $formatoAtencion->fecha_entrega ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Hora Entrega</dt><dd>{{ $formatoAtencion->hora_entrega ?? '—' }}</dd></div>
                </dl>

                <h3 class="text-lg font-semibold mb-4">Responsable</h3>
                <dl class="grid grid-cols-2 gap-4 mb-6">
                    <div><dt class="text-gray-500">Nombre</dt><dd>{{ $formatoAtencion->nombre_responsable ?? $formatoAtencion->responsable->nombres ?? '—' }}</dd></div>
                </dl>

                <div class="mt-4 space-x-2">
                    <a href="/formatos-atencion/{{ $formatoAtencion->id }}/edit" class="bg-blue-500 text-white px-4 py-2 rounded">Editar</a>
                    <a href="/tareas/{{ $formatoAtencion->tarea_id }}" class="text-blue-600 ml-2">Ver Tarea</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
