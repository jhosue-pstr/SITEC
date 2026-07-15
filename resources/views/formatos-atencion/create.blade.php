<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar Formato de Atención
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info de tarea --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $tarea->codigo }} — {{ $tarea->titulo }}</h3>
                            <p class="text-sm text-gray-500">Complete los campos para generar el formato de atención en PDF</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="/tareas/{{ $tarea->id }}/formatos-atencion" method="POST">
                @csrf

                {{-- Equipo --}}
                <div x-data="equipoData()" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Datos del Equipo</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Seleccionar Equipo</label>
                            <select name="equipo_id" x-model="selectedId" @change="fillFields()" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">— Seleccionar equipo existente —</option>
                                @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}"
                                    data-tipo="{{ $equipo->tipo_equipo }}"
                                    data-codigo="{{ $equipo->codigo_patrimonial }}"
                                    data-serie="{{ $equipo->numero_serie }}"
                                    data-marca="{{ $equipo->marca }}"
                                    data-modelo="{{ $equipo->modelo }}">{{ $equipo->tipo_equipo }} — {{ $equipo->codigo_patrimonial }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-400">Al seleccionar se autocompletarán los campos inferiores</p>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo</label>
                                <input type="text" name="tipo_equipo" x-model="tipoEquipo" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Laptop">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Cod. Patrimonial</label>
                                <input type="text" name="codigo_patrimonial" x-model="codigoPatrimonial" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: C-00123">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">N° Serie</label>
                                <input type="text" name="numero_serie" x-model="numeroSerie" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: SN-001">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Marca</label>
                                <input type="text" name="marca" x-model="marca" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: HP">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Modelo</label>
                                <input type="text" name="modelo" x-model="modelo" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: EliteBook">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Datos del solicitante --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Datos del Solicitante</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombres</label>
                                <input type="text" name="nombres_solicitante" value="{{ $defaults['nombres_solicitante'] ?? '' }}" required class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Apellidos</label>
                                <input type="text" name="apellidos_solicitante" value="{{ $defaults['apellidos_solicitante'] ?? '' }}" required class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">DNI</label>
                                <input type="text" name="dni_solicitante" value="{{ $defaults['dni_solicitante'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Número de documento">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Teléfono Móvil</label>
                                <input type="text" name="telefono_movil" value="{{ $defaults['telefono_movil'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 999888777">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Régimen Laboral</label>
                                <select name="regimen_laboral" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="Nombrado" @selected(($defaults['regimen_laboral'] ?? '') == 'Nombrado')>Nombrado</option>
                                    <option value="Permanente" @selected(($defaults['regimen_laboral'] ?? '') == 'Permanente')>Permanente</option>
                                    <option value="CAS" @selected(($defaults['regimen_laboral'] ?? '') == 'CAS')>CAS</option>
                                    <option value="CAS Confianza" @selected(($defaults['regimen_laboral'] ?? '') == 'CAS Confianza')>CAS Confianza</option>
                                    <option value="DL 276" @selected(($defaults['regimen_laboral'] ?? '') == 'DL 276')>DL 276</option>
                                    <option value="DL 728" @selected(($defaults['regimen_laboral'] ?? '') == 'DL 728')>DL 728</option>
                                    <option value="DL 1057" @selected(($defaults['regimen_laboral'] ?? '') == 'DL 1057')>DL 1057</option>
                                    <option value="otros" @selected(($defaults['regimen_laboral'] ?? '') == 'otros')>Otros</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Cargo</label>
                                <input type="text" name="cargo" value="{{ $defaults['cargo'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Analista de Sistemas">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Unidad de Organización</label>
                                <input type="text" name="unidad_organizacion" value="{{ $defaults['unidad_organizacion'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Dirección de Tecnologías">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detalle de atención --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Detalle de Atención</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipo de Soporte Informático</label>
                            <select name="tipo_soporte_informatico" required class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar...</option>
                                <option value="hardware" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'hardware')>Hardware</option>
                                <option value="software" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'software')>Software</option>
                                <option value="red" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'red')>Red</option>
                                <option value="impresion" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'impresion')>Impresión</option>
                                <option value="otro" @selected(($defaults['tipo_soporte_informatico'] ?? '') == 'otro')>Otro</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Reporte del Usuario</label>
                                <textarea name="reporte_usuario" required rows="4" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="¿Qué problema reporta el usuario?">{{ $defaults['reporte_usuario'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Diagnóstico Técnico</label>
                                <textarea name="diagnostico_tecnico" rows="4" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Análisis técnico del problema...">{{ $defaults['diagnostico_tecnico'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Observaciones</label>
                            <textarea name="observaciones" rows="2" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Notas adicionales...">{{ $defaults['observaciones'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Fechas y responsable --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Fechas y Responsable</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha de Atención</label>
                                <input type="date" name="fecha_atencion" value="{{ $defaults['fecha_atencion'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Hora de Atención</label>
                                <input type="time" name="hora_atencion" value="{{ $defaults['hora_atencion'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Fecha de Entrega</label>
                                <input type="date" name="fecha_entrega" value="{{ $defaults['fecha_entrega'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Hora de Entrega</label>
                                <input type="time" name="hora_entrega" value="{{ $defaults['hora_entrega'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre del Responsable</label>
                            <input type="text" name="nombre_responsable" value="{{ $defaults['nombre_responsable'] ?? '' }}" class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nombre completo del responsable">
                        </div>
                    </div>
                </div>

                {{-- Firmas --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Firmas</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <input type="hidden" name="firma_responsable_data" id="firma_responsable_data">
                        <input type="hidden" name="firma_solicitante_data" id="firma_solicitante_data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div data-signature-pad data-tipo="responsable">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Firma del Responsable del Procedimiento</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white">
                                    <canvas class="w-full" style="height: 150px;"></canvas>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="button" data-clear class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Limpiar</button>
                                </div>
                            </div>
                            <div data-signature-pad data-tipo="solicitante">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Firma del Solicitante</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white">
                                    <canvas class="w-full" style="height: 150px;"></canvas>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="button" data-clear class="flex-1 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Limpiar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-end gap-3 mt-6 pb-8">
                    <a href="/tareas/{{ $tarea->id }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Generar Formato
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function equipoData() {
            return {
                selectedId: '',
                tipoEquipo: @js($defaults['tipo_equipo'] ?? ''),
                codigoPatrimonial: @js($defaults['codigo_patrimonial'] ?? ''),
                numeroSerie: @js($defaults['numero_serie'] ?? ''),
                marca: @js($defaults['marca'] ?? ''),
                modelo: @js($defaults['modelo'] ?? ''),
                fillFields() {
                    const select = document.querySelector('select[name="equipo_id"]');
                    const option = select.options[select.selectedIndex];
                    if (this.selectedId) {
                        this.tipoEquipo = option.dataset.tipo || '';
                        this.codigoPatrimonial = option.dataset.codigo || '';
                        this.numeroSerie = option.dataset.serie || '';
                        this.marca = option.dataset.marca || '';
                        this.modelo = option.dataset.modelo || '';
                    } else {
                        this.tipoEquipo = '';
                        this.codigoPatrimonial = '';
                        this.numeroSerie = '';
                        this.marca = '';
                        this.modelo = '';
                    }
                }
            }
        }
    </script>
</x-app-layout>