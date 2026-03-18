<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zenith Support | Gestión Técnica Profesional</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-['Figtree'] bg-white text-[#1e3d6c]">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center space-x-2">
                    <x-application-logo class="block h-10 w-auto fill-current text-indigo-600" />
                </div>
                
                <div class="hidden md:flex items-center space-x-8 font-semibold">
                    <a href="#inicio" class="hover:text-[#41bcb0] transition">Inicio</a>
                    <a href="#planes" class="hover:text-[#41bcb0] transition">Planes</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-[#1e3d6c] text-white px-6 py-2 rounded-full hover:bg-[#41bcb0] transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-[#1e3d6c] hover:text-[#41bcb0]">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="bg-[#90cc58] text-white px-6 py-2 rounded-full font-bold shadow-sm hover:shadow-md transition">Registrarse</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section id="inicio" class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gradient-to-b from-slate-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl lg:text-7xl font-black leading-tight tracking-tight">
                El control total de tu <br>
                <span class="text-[#41bcb0]">taller técnico</span> ha llegado.
            </h1>
            <p class="mt-8 text-xl text-slate-600 max-w-3xl mx-auto">
                Zenith Support simplifica la gestión de ingresos, reparaciones y entregas. Profesionaliza tu negocio hoy mismo.
            </p>
            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-[#90cc58] text-white font-black text-lg rounded-xl shadow-xl hover:scale-105 transition transform">
                    EMPEZAR AHORA
                </a>
                <a href="#planes" class="px-10 py-4 bg-white text-[#1e3d6c] border-2 border-[#1e3d6c] font-black text-lg rounded-xl hover:bg-slate-50 transition">
                    VER PLANES
                </a>
            </div>
        </div>
    </section>

    <section id="planes" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black tracking-tight">Membresías Zenith</h2>
                <p class="text-slate-500 mt-4">Escala tu negocio según tus necesidades</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-3xl border border-slate-200 flex flex-col">
                    <h3 class="text-xl font-bold text-slate-400 uppercase tracking-widest">Estándar</h3>
                    <div class="my-6">
                        <span class="text-5xl font-black">$0</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-slate-600">
                        <li class="flex items-center gap-2">✓ Registro de Equipos</li>
                        <li class="flex items-center gap-2">✓ Gestión de Fallas</li>
                        <li class="flex items-center gap-2 text-slate-300">✗ Reportes Mensuales PDF</li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-3 text-center border-2 border-[#1e3d6c] font-bold rounded-xl hover:bg-slate-50 transition">Acceso Gratis</a>
                </div>

                <div class="p-8 rounded-3xl border-4 border-[#41bcb0] relative shadow-2xl flex flex-col scale-105 bg-white">
                    <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#41bcb0] text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Recomendado</span>
                    <h3 class="text-xl font-bold text-[#41bcb0] uppercase tracking-widest">Basic</h3>
                    <div class="my-6">
                        <span class="text-5xl font-black">$9,99</span><span class="text-slate-400">/mes</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-slate-600">
                        <li class="flex items-center gap-2 font-bold text-[#1e3d6c]">✓ Todo lo de Estándar</li>
                        <li class="flex items-center gap-2">✓ Tickets de Recepción</li>
                        <li class="flex items-center gap-2 text-slate-300">✗ Reportes Mensuales PDF</li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-3 text-center bg-[#41bcb0] text-white font-bold rounded-xl shadow-lg hover:brightness-110 transition">Suscribirse</a>
                </div>

                <div class="p-8 rounded-3xl border border-slate-200 bg-[#1e3d6c] flex flex-col">
                    <h3 class="text-xl font-bold text-[#41bcb0] uppercase tracking-widest">Pro</h3>
                    <div class="my-6 text-white">
                        <span class="text-5xl font-black">$19,99</span><span class="text-slate-400">/mes</span>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-slate-300">
                        <li class="flex items-center gap-2 font-bold text-white">✓ Todo lo de Basic</li>
                        <li class="flex items-center gap-2">✓ Reportes PDF</li>
                        <li class="flex items-center gap-2 text-[#90cc58]">✓ Gráficos de Ventas</li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-3 text-center bg-white text-[#1e3d6c] font-bold rounded-xl hover:bg-slate-100 transition">Ser Pro</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-50 py-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-bold text-[#1e3d6c]">&copy; 2026 Zenith Support. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>