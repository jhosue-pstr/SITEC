<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <div class="flex-1 flex flex-col">
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1 flex flex-col min-h-0">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <x-toast />
        <x-confirm-dialog />

        @if(session('toast_success'))
            <script>document.addEventListener('DOMContentLoaded', () => window.dispatchEvent(new CustomEvent('show-toast', { detail: { type: 'success', message: '{{ session('toast_success') }}' } })))</script>
        @endif
        @if(session('toast_error'))
            <script>document.addEventListener('DOMContentLoaded', () => window.dispatchEvent(new CustomEvent('show-toast', { detail: { type: 'error', message: '{{ session('toast_error') }}' } })))</script>
        @endif
        @if(session('toast_warning'))
            <script>document.addEventListener('DOMContentLoaded', () => window.dispatchEvent(new CustomEvent('show-toast', { detail: { type: 'warning', message: '{{ session('toast_warning') }}' } })))</script>
        @endif
        @if($errors->any())
            <script>document.addEventListener('DOMContentLoaded', () => window.dispatchEvent(new CustomEvent('show-toast', { detail: { type: 'error', message: '{{ $errors->first() }}' } })))</script>
        @endif
    </body>
</html>
