@props(['tarea'])

@php
    $prioridad = $tarea->prioridad;
    $tagClass = match($prioridad) {
        'critica', 'alta' => 'high',
        'media' => 'medium',
        default => 'low',
    };
    $tagLabel = match($prioridad) {
        'critica' => 'CRÍTICA',
        'alta' => 'ALTA',
        'media' => 'MEDIA',
        'baja' => 'BAJA',
        default => strtoupper($prioridad),
    };
@endphp

<div class="task" x-data="{ open: false }">
    <div class="flex items-center justify-between gap-2" style="cursor:pointer" @click="open = !open">
        <h4 style="margin:0;flex:1" class="text-sm">{{ $tarea->codigo }} · {{ $tarea->titulo }}</h4>
        <button @click.stop="open = !open" class="btn-expand" x-text="open ? 'Contraer' : 'Expandir'"></button>
    </div>

    <div x-show="open" x-transition:enter.duration.200ms x-cloak style="padding-top:10px;margin-top:10px;border-top:1px solid var(--line)">
        <span class="tag {{ $tagClass }}">{{ $tagLabel }}</span>
        <small>📍 {{ $tarea->oficina->nombre ?? 'Sin oficina' }}{{ $tarea->ubicacion_detalle ? ' · '.$tarea->ubicacion_detalle : '' }}</small>
        <small>👤 {{ $tarea->solicitante->nombres ?? '' }} {{ $tarea->solicitante->apellidos ?? '' }}</small>
        @if($tarea->practicanteAsignado)
            <small>🛠 Responsable: {{ $tarea->practicanteAsignado->nombres }}</small>
        @endif
        @if($tarea->evidencias_count)
            <small>📷 {{ $tarea->evidencias_count }} evidencia(s)</small>
        @endif
        <div class="mt-2 flex gap-2">
            @if($tarea->estado == 'pendiente')
                @if(auth()->user()->rol === 'practicante' && !$tarea->practicante_asignado_id)
                <form action="/tareas/{{ $tarea->id }}/autoasignar" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary">Aceptar</button>
                </form>
                @endif
                <a href="/tareas/{{ $tarea->id }}" class="btn-secondary">Ver detalle</a>
            @elseif(in_array($tarea->estado, ['asignado', 'en_proceso']))
                <a href="/tareas/{{ $tarea->id }}" class="btn-secondary">Ver atención</a>
            @elseif($tarea->estado == 'finalizado')
                <a href="/tareas/{{ $tarea->id }}" class="btn-secondary">Ver informe</a>
            @else
                <a href="/tareas/{{ $tarea->id }}" class="btn-secondary">Ver detalle</a>
            @endif
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
.btn-expand { background:none; border:1px solid var(--line); border-radius:6px; padding:4px 10px; font-size:12px; cursor:pointer; color:var(--muted); white-space:nowrap; }
.btn-expand:hover { background:#eaf0ec; }
.btn-primary { display:inline-block; border:0; border-radius:8px; padding:8px 12px; font-weight:700; font-size:13px; cursor:pointer; background:var(--primary); color:#fff; text-decoration:none; margin-top:4px; }
.btn-primary:hover { background:#0f4623; }
</style>
