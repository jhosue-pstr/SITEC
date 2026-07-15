<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Formato de Atención - {{ $formatoAtencion->tarea->codigo ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ editing: false }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Datos del Formato</h3>
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

                {{-- ============ MODO VISTA ============ --}}
                <div x-show="!editing">
                    <h4 class="font-semibold mb-2 text-gray-700">Datos del Solicitante</h4>
                    <dl class="grid grid-cols-2 gap-4 mb-6">
                        <div><dt class="text-gray-500">Nombres</dt><dd>{{ $formatoAtencion->nombres_solicitante }}</dd></div>
                        <div><dt class="text-gray-500">Apellidos</dt><dd>{{ $formatoAtencion->apellidos_solicitante }}</dd></div>
                        <div><dt class="text-gray-500">DNI</dt><dd>{{ $formatoAtencion->dni_solicitante ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Teléfono</dt><dd>{{ $formatoAtencion->telefono_movil ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Régimen Laboral</dt><dd>{{ $formatoAtencion->regimen_laboral ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Cargo</dt><dd>{{ $formatoAtencion->cargo ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Unidad/Organización</dt><dd>{{ $formatoAtencion->unidad_organizacion ?? '—' }}</dd></div>
                    </dl>

                    <h4 class="font-semibold mb-2 text-gray-700">Datos del Equipo</h4>
                    <dl class="grid grid-cols-2 gap-4 mb-6">
                        <div><dt class="text-gray-500">Equipo</dt><dd>
                            @if($formatoAtencion->equipo)
                                {{ $formatoAtencion->equipo->tipo_equipo }} - {{ $formatoAtencion->equipo->codigo_patrimonial }}
                            @else
                                {{ $formatoAtencion->tipo_equipo ? $formatoAtencion->tipo_equipo.' - '.$formatoAtencion->codigo_patrimonial : '—' }}
                            @endif
                        </dd></div>
                        <div><dt class="text-gray-500">Número de Serie</dt><dd>{{ $formatoAtencion->numero_serie ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Marca</dt><dd>{{ $formatoAtencion->marca ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Modelo</dt><dd>{{ $formatoAtencion->modelo ?? '—' }}</dd></div>
                    </dl>

                    <h4 class="font-semibold mb-2 text-gray-700">Detalle de Atención</h4>
                    <dl class="grid grid-cols-2 gap-4 mb-6">
                        <div><dt class="text-gray-500">Tipo Soporte</dt><dd>{{ $formatoAtencion->tipo_soporte_informatico }}</dd></div>
                        <div><dt class="text-gray-500">Reporte del Usuario</dt><dd class="whitespace-pre-line">{{ $formatoAtencion->reporte_usuario }}</dd></div>
                        <div><dt class="text-gray-500">Diagnóstico Técnico</dt><dd class="whitespace-pre-line">{{ $formatoAtencion->diagnostico_tecnico ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Observaciones</dt><dd class="whitespace-pre-line">{{ $formatoAtencion->observaciones ?? '—' }}</dd></div>
                    </dl>

                    <h4 class="font-semibold mb-2 text-gray-700">Fechas</h4>
                    <dl class="grid grid-cols-2 gap-4 mb-6">
                        <div><dt class="text-gray-500">Fecha Atención</dt><dd>{{ $formatoAtencion->fecha_atencion ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Hora Atención</dt><dd>{{ $formatoAtencion->hora_atencion ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Fecha Entrega</dt><dd>{{ $formatoAtencion->fecha_entrega ?? '—' }}</dd></div>
                        <div><dt class="text-gray-500">Hora Entrega</dt><dd>{{ $formatoAtencion->hora_entrega ?? '—' }}</dd></div>
                    </dl>

                    <h4 class="font-semibold mb-2 text-gray-700">Responsable</h4>
                    <dl class="grid grid-cols-2 gap-4 mb-6">
                        <div><dt class="text-gray-500">Nombre</dt><dd>{{ $formatoAtencion->nombre_responsable ?? $formatoAtencion->responsable->nombres ?? '—' }}</dd></div>
                    </dl>

                    <div class="mt-4 space-x-2">
                        <a href="/tareas/{{ $formatoAtencion->tarea_id }}" class="text-blue-600">Ver Tarea</a>
                    </div>
                </div>

                {{-- ============ MODO EDICIÓN ============ --}}
                <form x-show="editing" style="display: none;" action="/formatos-atencion/{{ $formatoAtencion->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    @php $equipos = \App\Models\Equipo::all(); @endphp

                    <h4 class="font-semibold mb-2 text-gray-700">Datos del Solicitante</h4>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><label class="text-gray-500 text-sm">Nombres</label><input type="text" name="nombres_solicitante" value="{{ old('nombres_solicitante', $formatoAtencion->nombres_solicitante) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Apellidos</label><input type="text" name="apellidos_solicitante" value="{{ old('apellidos_solicitante', $formatoAtencion->apellidos_solicitante) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">DNI</label><input type="text" name="dni_solicitante" value="{{ old('dni_solicitante', $formatoAtencion->dni_solicitante) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Teléfono</label><input type="text" name="telefono_movil" value="{{ old('telefono_movil', $formatoAtencion->telefono_movil) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Régimen Laboral</label>
                            <select name="regimen_laboral" class="mt-1 w-full border rounded px-3 py-2">
                                <option value="">Seleccionar...</option>
                                @foreach(['CAS','DL 276','DL 728','DL 1057','otros'] as $r)
                                    <option value="{{ $r }}" @selected(old('regimen_laboral', $formatoAtencion->regimen_laboral) == $r)>{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div><label class="text-gray-500 text-sm">Cargo</label><input type="text" name="cargo" value="{{ old('cargo', $formatoAtencion->cargo) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div class="md:col-span-2"><label class="text-gray-500 text-sm">Unidad/Organización</label><input type="text" name="unidad_organizacion" value="{{ old('unidad_organizacion', $formatoAtencion->unidad_organizacion) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                    </div>

                    <h4 class="font-semibold mb-2 text-gray-700">Datos del Equipo</h4>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><label class="text-gray-500 text-sm">Equipo</label>
                            <select name="equipo_id" class="mt-1 w-full border rounded px-3 py-2">
                                <option value="">Seleccionar...</option>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id }}" @selected(old('equipo_id', $formatoAtencion->equipo_id) == $equipo->id)>{{ $equipo->tipo_equipo }} - {{ $equipo->codigo_patrimonial }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div><label class="text-gray-500 text-sm">Número de Serie</label><input type="text" name="numero_serie" value="{{ old('numero_serie', $formatoAtencion->numero_serie) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Marca</label><input type="text" name="marca" value="{{ old('marca', $formatoAtencion->marca) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Modelo</label><input type="text" name="modelo" value="{{ old('modelo', $formatoAtencion->modelo) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                    </div>

                    <h4 class="font-semibold mb-2 text-gray-700">Detalle de Atención</h4>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><label class="text-gray-500 text-sm">Tipo Soporte</label>
                            <select name="tipo_soporte_informatico" class="mt-1 w-full border rounded px-3 py-2">
                                @foreach(['hardware','software','red','impresion','otro'] as $t)
                                    <option value="{{ $t }}" @selected(old('tipo_soporte_informatico', $formatoAtencion->tipo_soporte_informatico) == $t)>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2"><label class="text-gray-500 text-sm">Reporte del Usuario</label><textarea name="reporte_usuario" rows="3" class="mt-1 w-full border rounded px-3 py-2">{{ old('reporte_usuario', $formatoAtencion->reporte_usuario) }}</textarea></div>
                        <div class="md:col-span-2"><label class="text-gray-500 text-sm">Diagnóstico Técnico</label><textarea name="diagnostico_tecnico" rows="3" class="mt-1 w-full border rounded px-3 py-2">{{ old('diagnostico_tecnico', $formatoAtencion->diagnostico_tecnico) }}</textarea></div>
                        <div class="md:col-span-2"><label class="text-gray-500 text-sm">Observaciones</label><textarea name="observaciones" rows="2" class="mt-1 w-full border rounded px-3 py-2">{{ old('observaciones', $formatoAtencion->observaciones) }}</textarea></div>
                    </div>

                    <h4 class="font-semibold mb-2 text-gray-700">Fechas</h4>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div><label class="text-gray-500 text-sm">Fecha Atención</label><input type="date" name="fecha_atencion" value="{{ old('fecha_atencion', $formatoAtencion->fecha_atencion) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Hora Atención</label><input type="time" name="hora_atencion" value="{{ old('hora_atencion', $formatoAtencion->hora_atencion) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Fecha Entrega</label><input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', $formatoAtencion->fecha_entrega) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                        <div><label class="text-gray-500 text-sm">Hora Entrega</label><input type="time" name="hora_entrega" value="{{ old('hora_entrega', $formatoAtencion->hora_entrega) }}" class="mt-1 w-full border rounded px-3 py-2"></div>
                    </div>

                    <h4 class="font-semibold mb-2 text-gray-700">Firmas</h4>
                    <p class="text-sm text-gray-500 mb-2">Firme con el dedo en pantalla táctil o con el mouse en PC. Si ya existe una firma, se muestra; puede redibujarla.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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

                    <div class="mt-4 flex items-center gap-3">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
                        <button type="button" @click="editing = false" class="text-gray-600 px-4 py-2 rounded border">Cancelar</button>
                        <a href="/tareas/{{ $formatoAtencion->tarea_id }}" class="text-blue-600 ml-auto">Ver Tarea</a>
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
            fmtInit('canvas-responsable','firma_responsable','clear-responsable', @if($formatoAtencion->firma_responsable_url) '{{ asset('storage/'.$formatoAtencion->firma_responsable_url) }}' @else null @endif);
            fmtInit('canvas-solicitante','firma_solicitante','clear-solicitante', @if($formatoAtencion->firma_solicitante_url) '{{ asset('storage/'.$formatoAtencion->firma_solicitante_url) }}' @else null @endif);
        }
        window.fmtResizeAll = function(){ fmtResize('canvas-responsable'); fmtResize('canvas-solicitante'); };
        document.addEventListener('DOMContentLoaded', fmtInitAll);
    </script>
    @endpush
</x-app-layout>
