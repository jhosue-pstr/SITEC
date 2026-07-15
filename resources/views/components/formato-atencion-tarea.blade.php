@props(['tarea'])

@if($tarea->formatoAtencion ?? false)
@php
    $formato = $tarea->formatoAtencion;
    $equipos = \App\Models\Equipo::all();
@endphp
<div x-data="{ editing: false }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Formato de Atención</h3>
        @if(auth()->user()->rol === 'jefe')
        <div class="flex items-center gap-2">
            <button type="button" x-show="!editing" @click="editing = true; $nextTick(() => window.fmtResizeAll && window.fmtResizeAll())" class="inline-flex items-center gap-1.5 text-sm text-green-600 hover:text-green-800 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </button>
            <button type="button" x-show="editing" @click="editing = false" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 font-medium">
                Cancelar
            </button>
        </div>
        @endif
    </div>
    <div class="p-6">

        {{-- Modo vista --}}
        <div x-show="!editing">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombres</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->nombres_solicitante ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Apellidos</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->apellidos_solicitante ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">DNI</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->dni_solicitante ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Teléfono Móvil</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->telefono_movil ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Régimen Laboral</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->regimen_laboral ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Cargo</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->cargo ?? '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Unidad/Organización</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->unidad_organizacion ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo de Soporte</label>
                    <p class="mt-1 text-sm text-gray-700">{{ ucfirst($formato->tipo_soporte_informatico ?? '—') }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Equipo</label>
                    <p class="mt-1 text-sm text-gray-700">
                        @if($formato->equipo)
                            {{ $formato->equipo->tipo_equipo }} - {{ $formato->equipo->codigo_patrimonial }}
                        @else
                            {{ $formato->tipo_equipo ? $formato->tipo_equipo.' - '.$formato->codigo_patrimonial : '—' }}
                        @endif
                    </p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Reporte del Usuario</label>
                    <p class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $formato->reporte_usuario ?? '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico Técnico</label>
                    <p class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $formato->diagnostico_tecnico ?? '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                    <p class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $formato->observaciones ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha de Atención</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->fecha_atencion ?? '—' }} @if($formato->hora_atencion) {{ $formato->hora_atencion }} @endif</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha de Entrega</label>
                    <p class="mt-1 text-sm text-gray-700">{{ $formato->fecha_entrega ?? '—' }} @if($formato->hora_entrega) {{ $formato->hora_entrega }} @endif</p>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-gray-100 flex gap-2">
                <a href="/formatos-atencion/{{ $formato->id }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Ver / Firmas
                </a>
            </div>
        </div>

        {{-- Modo edición --}}
        <div x-show="editing" style="display: none;">
            <form action="/formatos-atencion/{{ $formato->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombres</label>
                        <input type="text" name="nombres_solicitante" value="{{ old('nombres_solicitante', $formato->nombres_solicitante) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Apellidos</label>
                        <input type="text" name="apellidos_solicitante" value="{{ old('apellidos_solicitante', $formato->apellidos_solicitante) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">DNI</label>
                        <input type="text" name="dni_solicitante" value="{{ old('dni_solicitante', $formato->dni_solicitante) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Teléfono Móvil</label>
                        <input type="text" name="telefono_movil" value="{{ old('telefono_movil', $formato->telefono_movil) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Régimen Laboral</label>
                        <select name="regimen_laboral" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccionar...</option>
                            @foreach(['CAS','DL 276','DL 728','DL 1057','otros'] as $r)
                                <option value="{{ $r }}" @selected(old('regimen_laboral', $formato->regimen_laboral) == $r)>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Cargo</label>
                        <input type="text" name="cargo" value="{{ old('cargo', $formato->cargo) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Unidad/Organización</label>
                        <input type="text" name="unidad_organizacion" value="{{ old('unidad_organizacion', $formato->unidad_organizacion) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo de Soporte</label>
                        <select name="tipo_soporte_informatico" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach(['hardware','software','red','impresion','otro'] as $t)
                                <option value="{{ $t }}" @selected(old('tipo_soporte_informatico', $formato->tipo_soporte_informatico) == $t)>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Equipo</label>
                        <select name="equipo_id" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccionar...</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" @selected(old('equipo_id', $formato->equipo_id) == $equipo->id)>{{ $equipo->tipo_equipo }} - {{ $equipo->codigo_patrimonial }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Reporte del Usuario</label>
                        <textarea name="reporte_usuario" rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('reporte_usuario', $formato->reporte_usuario) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico Técnico</label>
                        <textarea name="diagnostico_tecnico" rows="3" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('diagnostico_tecnico', $formato->diagnostico_tecnico) }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                        <textarea name="observaciones" rows="2" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('observaciones', $formato->observaciones) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha de Atención</label>
                        <input type="date" name="fecha_atencion" value="{{ old('fecha_atencion', $formato->fecha_atencion) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Hora de Atención</label>
                        <input type="time" name="hora_atencion" value="{{ old('hora_atencion', $formato->hora_atencion) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha de Entrega</label>
                        <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', $formato->fecha_entrega) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Hora de Entrega</label>
                        <input type="time" name="hora_entrega" value="{{ old('hora_entrega', $formato->hora_entrega) }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <h4 class="font-semibold mb-2 text-gray-700">Firmas</h4>
                        <p class="text-sm text-gray-500 mb-2">Firme con el dedo en pantalla táctil o con el mouse en PC. Si ya existe una firma, se muestra; puede redibujarla.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Firma del Responsable (Técnico)</label>
                                <canvas id="canvas-responsable" class="w-full h-40 border border-gray-300 rounded bg-gray-50 touch-none"></canvas>
                                <button type="button" id="clear-responsable" class="mt-2 text-sm text-red-600">Limpiar</button>
                                <input type="hidden" name="firma_responsable" id="firma_responsable">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Firma del Solicitante</label>
                                <canvas id="canvas-solicitante" class="w-full h-40 border border-gray-300 rounded bg-gray-50 touch-none"></canvas>
                                <button type="button" id="clear-solicitante" class="mt-2 text-sm text-red-600">Limpiar</button>
                                <input type="hidden" name="firma_solicitante" id="firma_solicitante">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-100 flex gap-2">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Guardar
                        </button>
                        <button type="button" @click="editing = false" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function fmtResize(id) {
            const c = document.getElementById(id);
            if (!c) return;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const r = c.getBoundingClientRect();
            c.width = r.width * ratio;
            c.height = r.height * ratio;
            const ctx = c.getContext('2d');
            ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
            ctx.lineWidth = 2; ctx.lineCap = 'round'; ctx.lineJoin = 'round'; ctx.strokeStyle = '#111827';
        }
        function fmtInit(canvasId, inputId, clearId, existingUrl) {
            const canvas = document.getElementById(canvasId);
            const input = document.getElementById(inputId);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let drawing = false, drawn = false;
            fmtResize(canvasId);
            window.addEventListener('resize', () => fmtResize(canvasId));
            function point(e){ const r = canvas.getBoundingClientRect(); return {x:e.clientX-r.left, y:e.clientY-r.top}; }
            canvas.addEventListener('pointerdown', e => { drawing=true; drawn=true; const p=point(e); ctx.beginPath(); ctx.moveTo(p.x,p.y); canvas.setPointerCapture(e.pointerId); e.preventDefault(); });
            canvas.addEventListener('pointermove', e => { if(!drawing) return; const p=point(e); ctx.lineTo(p.x,p.y); ctx.stroke(); e.preventDefault(); });
            const stop = e => { drawing=false; e.preventDefault(); };
            canvas.addEventListener('pointerup', stop);
            canvas.addEventListener('pointerleave', stop);
            document.getElementById(clearId).addEventListener('click', () => { ctx.clearRect(0,0,canvas.width,canvas.height); input.value=''; drawn=false; });
            canvas.closest('form').addEventListener('submit', () => { if(drawn) input.value = canvas.toDataURL('image/png'); });
            if (existingUrl) {
                const img = new Image();
                img.onload = () => { fmtResize(canvasId); ctx.drawImage(img, 0, 0, canvas.getBoundingClientRect().width, canvas.getBoundingClientRect().height); };
                img.src = existingUrl;
            }
        }
        function fmtInitAll() {
            fmtInit('canvas-responsable','firma_responsable','clear-responsable', @if($formato->firma_responsable_url) '{{ asset('storage/'.$formato->firma_responsable_url) }}' @else null @endif);
            fmtInit('canvas-solicitante','firma_solicitante','clear-solicitante', @if($formato->firma_solicitante_url) '{{ asset('storage/'.$formato->firma_solicitante_url) }}' @else null @endif);
        }
        window.fmtResizeAll = function(){ fmtResize('canvas-responsable'); fmtResize('canvas-solicitante'); };
        document.addEventListener('DOMContentLoaded', fmtInitAll);
    </script>
    @endpush

@elseif($tarea->atencion)
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-900">Formato de Atención</h3>
    </div>
    <div class="p-6 flex items-center justify-between">
        <p class="text-sm text-gray-600">Genera el formato PDF de atención para esta tarea.</p>
        <a href="/tareas/{{ $tarea->id }}/formatos-atencion/create" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Generar Formato
        </a>
    </div>
</div>
@endif
