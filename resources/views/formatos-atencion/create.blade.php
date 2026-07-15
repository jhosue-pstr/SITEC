<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar Formato de Atención
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-gray-600">Tarea: <strong>{{ $tarea->codigo }}</strong> - {{ $tarea->titulo }}</p>

                <form action="/tareas/{{ $tarea->id }}/formatos-atencion" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Equipo</label>
                        <select name="equipo_id" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}">{{ $equipo->tipo_equipo }} - {{ $equipo->codigo_patrimonial }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Datos del Solicitante</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Nombres</label>
                            <input type="text" name="nombres_solicitante" value="{{ $defaults['nombres_solicitante'] ?? '' }}" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Apellidos</label>
                            <input type="text" name="apellidos_solicitante" value="{{ $defaults['apellidos_solicitante'] ?? '' }}" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">DNI</label>
                            <input type="text" name="dni_solicitante" value="{{ $defaults['dni_solicitante'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Teléfono Móvil</label>
                            <input type="text" name="telefono_movil" value="{{ $defaults['telefono_movil'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Régimen Laboral</label>
                            <select name="regimen_laboral" class="w-full border rounded px-3 py-2 mt-1">
                                <option value="">Seleccionar...</option>
                                <option value="CAS" @selected(($defaults['regimen_laboral'] ?? '') == 'CAS')>CAS</option>
                                <option value="DL 276" @selected(($defaults['regimen_laboral'] ?? '') == 'DL 276')>DL 276</option>
                                <option value="DL 728" @selected(($defaults['regimen_laboral'] ?? '') == 'DL 728')>DL 728</option>
                                <option value="DL 1057" @selected(($defaults['regimen_laboral'] ?? '') == 'DL 1057')>DL 1057</option>
                                <option value="otros" @selected(($defaults['regimen_laboral'] ?? '') == 'otros')>Otros</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Cargo</label>
                            <input type="text" name="cargo" value="{{ $defaults['cargo'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Unidad/Organización</label>
                            <input type="text" name="unidad_organizacion" value="{{ $defaults['unidad_organizacion'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Detalle de Atención</h3>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de Soporte Informático</label>
                        <select name="tipo_soporte_informatico" required class="w-full border rounded px-3 py-2 mt-1">
                            <option value="">Seleccionar...</option>
                            <option value="hardware" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'hardware')>Hardware</option>
                            <option value="software" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'software')>Software</option>
                            <option value="red" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'red')>Red</option>
                            <option value="impresion" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'impresion')>Impresión</option>
                            <option value="otro" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'otro')>Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Reporte del Usuario</label>
                        <textarea name="reporte_usuario" required class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $defaults['reporte_usuario'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Diagnóstico Técnico</label>
                        <textarea name="diagnostico_tecnico" class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $defaults['diagnostico_tecnico'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded px-3 py-2 mt-1" rows="2">{{ $defaults['observaciones'] ?? '' }}</textarea>
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Fechas</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Fecha de Atención</label>
                            <input type="date" name="fecha_atencion" value="{{ $defaults['fecha_atencion'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Hora de Atención</label>
                            <input type="time" name="hora_atencion" value="{{ $defaults['hora_atencion'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Fecha de Entrega</label>
                            <input type="date" name="fecha_entrega" value="{{ $defaults['fecha_entrega'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Hora de Entrega</label>
                            <input type="time" name="hora_entrega" value="{{ $defaults['hora_entrega'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre del Responsable</label>
                        <input type="text" name="nombre_responsable" value="{{ $defaults['nombre_responsable'] ?? '' }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <h3 class="font-semibold mt-6 mb-4">Firmas</h3>
                    <p class="text-sm text-gray-500 mb-4">Firme con el dedo en pantalla táctil o con el mouse en PC.</p>

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

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-6">Guardar Formato</button>
                    <a href="/tareas/{{ $tarea->id }}" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function initSignature(canvasId, inputId, clearId, existingUrl = null) {
            const canvas = document.getElementById(canvasId);
            const input = document.getElementById(inputId);
            const ctx = canvas.getContext('2d');
            let drawing = false;
            let drawn = false;

            function resize() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const rect = canvas.getBoundingClientRect();
                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;
                ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#111827';

                if (existingUrl && !drawn) {
                    const img = new Image();
                    img.onload = () => ctx.drawImage(img, 0, 0, rect.width, rect.height);
                    img.src = existingUrl;
                }
            }
            resize();
            window.addEventListener('resize', resize);

            function point(e) {
                const rect = canvas.getBoundingClientRect();
                return { x: e.clientX - rect.left, y: e.clientY - rect.top };
            }

            canvas.addEventListener('pointerdown', (e) => {
                drawing = true;
                drawn = true;
                const p = point(e);
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
                canvas.setPointerCapture(e.pointerId);
                e.preventDefault();
            });
            canvas.addEventListener('pointermove', (e) => {
                if (!drawing) return;
                const p = point(e);
                ctx.lineTo(p.x, p.y);
                ctx.stroke();
                e.preventDefault();
            });
            const stop = (e) => { drawing = false; e.preventDefault(); };
            canvas.addEventListener('pointerup', stop);
            canvas.addEventListener('pointerleave', stop);

            document.getElementById(clearId).addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                input.value = '';
                drawn = false;
            });

            canvas.closest('form').addEventListener('submit', () => {
                if (drawn) {
                    input.value = canvas.toDataURL('image/png');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initSignature('canvas-responsable', 'firma_responsable', 'clear-responsable', null);
            initSignature('canvas-solicitante', 'firma_solicitante', 'clear-solicitante', null);
        });
    </script>
    @endpush
</x-app-layout>
