@props(['tarea'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-900">Comentarios</h3>
    </div>
    <div class="p-6">
        @if($tarea->comentarios->count())
        <div class="space-y-4 mb-6">
            @foreach($tarea->comentarios as $comentario)
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 shrink-0">
                    {{ strtoupper(substr($comentario->usuario->nombres ?? '?', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-900">{{ $comentario->usuario->nombres ?? '—' }} {{ $comentario->usuario->apellidos ?? '' }}</span>
                        <span class="text-xs text-gray-400">{{ $comentario->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-700">{{ $comentario->comentario }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-6 text-gray-400">
            <p class="text-sm">Sin comentarios aún.</p>
        </div>
        @endif

        <form action="/tareas/{{ $tarea->id }}/comentarios" method="POST" class="border-t border-gray-100 pt-5">
            @csrf
            <textarea name="comentario" required class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="2" placeholder="Escribir comentario..."></textarea>
            <div class="mt-3 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Comentar
                </button>
            </div>
        </form>
    </div>
</div>
