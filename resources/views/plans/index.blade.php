<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selecciona tu Suscripción') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-3xl font-bold text-gray-900 italic">Zenith <span class="text-blue-600">Support</span></h3>
                <p class="text-gray-600 mt-2">Planes diseñados para escalar tu servicio técnico.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($plans as $plan)
                    @php
                        // Determinamos si es el plan Pro para aplicar estilos especiales
                        $isPro = str_contains(strtolower($plan->name), 'pro');
                    @endphp

                    <div class="relative bg-white p-8 rounded-2xl border-2 {{ $isPro ? 'border-blue-500 shadow-xl' : 'border-gray-200 shadow-sm' }} flex flex-col hover:shadow-lg transition-all duration-300">
                        
                        {{-- Etiqueta de Recomendado para el Plan Pro --}}
                        @if($isPro)
                            <span class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white text-xs font-bold px-4 py-1 rounded-full uppercase tracking-widest">
                                Más Popular
                            </span>
                        @endif

                        <div class="mb-6">
                            <h4 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h4>
                            <p class="text-gray-500 mt-2 text-sm">{{ $plan->description }}</p>
                        </div>

                        <div class="mb-8">
                            <span class="text-5xl font-extrabold text-gray-900">${{ number_format($plan->price / 100, 2) }}</span>
                            <span class="text-gray-500 font-medium">/mes</span>
                        </div>

                        {{-- Lista de Beneficios Dinámica --}}
                        <ul class="mb-8 space-y-4 flex-grow text-gray-600">
                            <li class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isPro ? 'Reparaciones Ilimitadas' : 'Hasta 10 reparaciones/mes' }}</span>
                            </li>

                            <li class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isPro ? 'Dashboard con Gráficos de Rendimiento' : 'Dashboard Estándar' }}</span>
                            </li>

                            <li class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $isPro ? 'Soporte Prioritario 24/7' : 'Soporte vía Ticket' }}</span>
                            </li>

                            <li class="flex items-center text-sm {{ !$isPro ? 'opacity-40' : '' }}">
                                @if($isPro)
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="font-bold">Herramientas de Diagnóstico Cloud</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="line-through">Herramientas de Diagnóstico Cloud</span>
                                @endif
                            </li>
                        </ul>

                        {{-- Botón de Acción --}}
                        <a href="{{ route('checkout', $plan->slug) }}" 
                           class="block w-full text-center py-4 rounded-xl font-bold transition-all duration-200 
                           {{ $isPro ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-lg shadow-blue-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            Elegir {{ $plan->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>