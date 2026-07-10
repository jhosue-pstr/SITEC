<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<aside class="w-64 min-h-screen bg-gray-900 text-white flex flex-col">
    <div class="p-4 border-b border-gray-700">
        <a href="{{ route('dashboard') }}" wire:navigate class="text-lg font-bold">SITEC</a>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        <a href="{{ route('dashboard') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('tareas.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('tareas.index') && !request('estado') ? 'bg-gray-700' : '' }}">
            Tareas
        </a>
        @if(auth()->user()->rol === 'practicante')
        <a href="{{ route('tareas.index', ['estado' => 'curso']) }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request('estado') === 'curso' ? 'bg-gray-700' : '' }}">
            Tareas en curso
        </a>
        @endif
        <a href="{{ route('notificaciones.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('notificaciones.*') ? 'bg-gray-700' : '' }}">
            Notificaciones
        </a>
        @if(auth()->user()->rol === 'jefe')
        <a href="{{ route('oficinas.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('oficinas.*') ? 'bg-gray-700' : '' }}">
            Oficinas
        </a>
        <a href="{{ route('equipos.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('equipos.*') ? 'bg-gray-700' : '' }}">
            Equipos
        </a>
        <a href="{{ route('usuarios.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('usuarios.*') ? 'bg-gray-700' : '' }}">
            Usuarios
        </a>
        <a href="{{ route('solicitudes-whatsapp.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('solicitudes-whatsapp.*') ? 'bg-gray-700' : '' }}">
            Solicitudes WhatsApp
        </a>
        @endif
        @if(in_array(auth()->user()->rol, ['jefe', 'practicante']))
        <a href="{{ route('formatos-atencion.index') }}" wire:navigate
            class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('formatos-atencion.*') ? 'bg-gray-700' : '' }}">
            Formatos de Atención
        </a>
        @endif
    </nav>

    <div class="p-4 border-t border-gray-700">
        <div class="text-sm">{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</div>
        <div class="text-xs text-gray-400">{{ auth()->user()->correo }}</div>
        <button wire:click="logout" class="mt-2 text-sm text-red-400 hover:text-red-300">Cerrar sesión</button>
    </div>
</aside>
