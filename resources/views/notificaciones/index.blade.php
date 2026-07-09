<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notificaciones
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($notificaciones->count())
                <div class="space-y-3">
                    @foreach($notificaciones as $notificacion)
                    <div class="border-b pb-3 {{ $notificacion->leida ? '' : 'bg-blue-50 p-3 rounded' }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold">{{ $notificacion->titulo }}</h4>
                                <p class="text-gray-600">{{ $notificacion->mensaje }}</p>
                                @if($notificacion->tarea)
                                <a href="/tareas/{{ $notificacion->tarea_id }}" class="text-blue-600 text-sm">Ver tarea {{ $notificacion->tarea->codigo }}</a>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $notificacion->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @if(!$notificacion->leida)
                            <form action="/notificaciones/{{ $notificacion->id }}/leida" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 text-sm">Marcar leída</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">No tienes notificaciones.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
