<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $correo = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'correo' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            ['correo' => $this->correo]
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('correo', __($status));

            return;
        }

        $this->reset('correo');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('¿Olvidaste tu contraseña? Indica tu correo y te enviaremos un enlace para restablecerla.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <div>
            <x-input-label for="correo" :value="__('Correo')" />
            <x-text-input wire:model="correo" id="correo" class="block mt-1 w-full" type="email" name="correo" required autofocus />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar enlace') }}
            </x-primary-button>
        </div>
    </form>
</div>
