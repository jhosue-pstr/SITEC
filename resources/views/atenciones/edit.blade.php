<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Atención
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="/atenciones/{{ $atencion->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Diagnóstico</label>
                        <textarea name="diagnostico" required class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $atencion->diagnostico }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Actividades Realizadas</label>
                        <textarea name="actividades_realizadas" class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $atencion->actividades_realizadas }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Solución Aplicada</label>
                        <textarea name="solucion_aplicada" class="w-full border rounded px-3 py-2 mt-1" rows="3">{{ $atencion->solucion_aplicada }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded px-3 py-2 mt-1" rows="2">{{ $atencion->observaciones }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tiempo de Atención (minutos)</label>
                        <input type="number" name="tiempo_atencion_minutos" value="{{ $atencion->tiempo_atencion_minutos }}" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                    <a href="/tareas/{{ $atencion->tarea_id }}" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
