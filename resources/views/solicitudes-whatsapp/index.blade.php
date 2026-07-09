<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitudes WhatsApp
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full mt-4">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Número</th>
                            <th class="text-left py-2">Mensaje</th>
                            <th class="text-left py-2">Estado</th>
                            <th class="text-left py-2">Tarea</th>
                            <th class="text-left py-2">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                        <tr class="border-b">
                            <td class="py-2">{{ $solicitud->numero_whatsapp }}</td>
                            <td class="py-2">{{ Str::limit($solicitud->mensaje_original, 50) }}</td>
                            <td class="py-2">{{ $solicitud->estado_conversacion }}</td>
                            <td class="py-2">{{ $solicitud->tarea->codigo ?? '—' }}</td>
                            <td class="py-2">{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
