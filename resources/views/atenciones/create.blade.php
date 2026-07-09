<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Atención
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-4 text-gray-600">Tarea: <strong>{{ $tarea->codigo }}</strong> - {{ $tarea->titulo }}</p>

                <form action="/tareas/{{ $tarea->id }}/atenciones" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Diagnóstico</label>
                        <textarea name="diagnostico" required class="w-full border rounded px-3 py-2 mt-1" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Actividades Realizadas</label>
                        <textarea name="actividades_realizadas" class="w-full border rounded px-3 py-2 mt-1" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Solución Aplicada</label>
                        <textarea name="solucion_aplicada" class="w-full border rounded px-3 py-2 mt-1" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded px-3 py-2 mt-1" rows="2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tiempo de Atención (minutos)</label>
                        <input type="number" name="tiempo_atencion_minutos" class="w-full border rounded px-3 py-2 mt-1">
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Finalizar Atención</button>
                    <a href="/tareas/{{ $tarea->id }}" class="ml-2 text-gray-600">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
