@props(['tarea'])

@php $evidencias = $tarea->evidencias ?? collect(); @endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Evidencias</h3>
        <span class="text-xs text-gray-500">{{ $evidencias->count() }} archivo(s)</span>
    </div>
    <div class="p-6 space-y-4">

        <div class="space-y-2">
            @forelse($evidencias as $evidencia)
            @php
                $url = $evidencia->url_archivo
                    ? (str_starts_with($evidencia->url_archivo, 'http')
                        ? $evidencia->url_archivo
                        : Storage::url($evidencia->url_archivo))
                    : null;
            @endphp
            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex items-center gap-3 min-w-0">
                    <svg class="w-8 h-8 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $evidencia->nombre_archivo }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    @if($url)
                    <span class="p-1.5 text-gray-400 cursor-default" title="Ver">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/></svg>
                    </span>
                    @endif
                    <span class="p-1.5 text-gray-400 cursor-default" title="Eliminar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-sm">Sin evidencias registradas.</p>
            </div>
            @endforelse
        </div>

        <div class="border-t border-gray-100 pt-4">
            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 cursor-default">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.828 5.328a.5.5 0 01.414-.172h3.516a.5.5 0 01.414.172l1.578 1.84a.5.5 0 00.414.172H20a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2v-8a2 2 0 012-2h3.836a.5.5 0 00.414-.172L9.828 5.328z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Tomar foto
            </span>
        </div>
    </div>
</div>
