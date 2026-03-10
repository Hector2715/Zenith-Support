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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @vite(['resources/css/app.css', 'resources/css/zenith.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />
            
            @livewireScripts

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
        <footer class="footer-zenith">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <h3 class="text-[#1e3d6c] font-black uppercase tracking-tighter text-lg">
                            Zenith <span class="text-[#41bcb0]">Support</span>
                        </h3>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                            Gestión Pro • v2.0
                        </p>
                    </div>

                    <div class="flex gap-6">
                        <a href="{{ route('legal.terminos') }}" class="footer-link">Términos</a>
                        <a href="{{ route('legal.privacidad') }}" class="footer-link">Privacidad</a>
                        <a href="{{ route('legal.soporte') }}" class="footer-link text-[#41bcb0]">Soporte Técnico</a>
                    </div>

                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.3em]">
                        &copy; {{ date('Y') }} Desarrollado por Hectech.
                    </div>
                </div>
            </div>
        </footer>
        {{-- Script para automatizar wire:navigate en todos los links internos --}}
    <script>
    function zenithSmartNavigate() {
        // Seleccionamos todos los enlaces <a> que sean internos
        const links = document.querySelectorAll('a:not([wire\\:navigate]):not([target="_blank"])');
        
        links.forEach(link => {
            const url = link.getAttribute('href');
            
            // Verificamos que sea un link interno y no un archivo/ancla
            if (url && url.startsWith('/') || (url && url.includes(window.location.hostname))) {
                // Evitamos aplicar esto a rutas que generan descargas de PDF
                if (!url.includes('reporte') && !url.includes('ticket')) {
                    link.setAttribute('wire:navigate', '');
                }
            }
        });
    }

    // Ejecutar inmediatamente al cargar la página
    zenithSmartNavigate();

    // Re-ejecutar cada vez que Livewire cambie el contenido del DOM
    document.addEventListener('livewire:navigated', zenithSmartNavigate);
</script>
</body>
    </body>
</html>