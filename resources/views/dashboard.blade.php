<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Tareas Pendientes</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Tarea::where('estado', 'pendiente')->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Tareas en Proceso</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Tarea::whereIn('estado', ['asignado', 'en_proceso'])->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Tareas Finalizadas</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Tarea::where('estado', 'finalizado')->count() }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Equipos Registrados</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Equipo::count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Usuarios Activos</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Usuario::where('activo', true)->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm">Oficinas</h3>
                    <p class="text-3xl font-bold">{{ \App\Models\Oficina::count() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
