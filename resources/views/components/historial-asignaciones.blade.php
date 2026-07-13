@props(['tarea'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-900">Historial de Asignaciones</h3>
    </div>
    <div class="p-6">
        @if($tarea->asignaciones->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-2 font-semibold text-gray-600">Practicante</th>
                        <th class="text-left py-3 px-2 font-semibold text-gray-600">Tipo</th>
                        <th class="text-left py-3 px-2 font-semibold text-gray-600">Fecha</th>
                        <th class="text-right py-3 px-2 font-semibold text-gray-600">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarea->asignaciones as $asignacion)
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                        <td class="py-3 px-2 font-medium text-gray-900">{{ $asignacion->practicante->nombres ?? '—' }}</td>
                        <td class="py-3 px-2 text-gray-600">{{ $asignacion->tipo_asignacion }}</td>
                        <td class="py-3 px-2 text-gray-600">{{ $asignacion->fecha_asignacion->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-2 text-right">
                            @if($asignacion->activa)
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">Activa</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500">Inactiva</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-6 text-gray-400">
            <p class="text-sm">Sin asignaciones registradas.</p>
        </div>
        @endif
    </div>
</div>
