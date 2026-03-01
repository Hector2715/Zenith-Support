<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zenith Support') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        {{-- Quitamos dark:bg-gray-900 --}}
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            @if (isset($header))
                {{-- Quitamos dark:bg-gray-800 --}}
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                @if (session('status'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 8000)"
                         class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm flex justify-between items-center" role="alert">
                            <div>
                                <p class="font-bold">Éxito</p>
                                <p class="text-sm">{{ session('status') }}</p>
                            </div>
                            <button @click="show = false" class="text-green-700">
                                <span class="text-2xl">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </body>
</html>