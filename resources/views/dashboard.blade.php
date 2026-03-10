<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="font-black text-2xl text-[#1e3d6c] uppercase tracking-tighter">
                {{ auth()->user()->nombre_taller ?: __('Zenith Panel') }}
            </h2>
            <span class="badge-zenith badge-zenith-teal py-2 px-4 w-full sm:w-auto text-center">
                Plan {{ auth()->user()->subscribedToPrice(config('services.stripe.pro_price_id'), 'default') ? 'Pro' : 'Basic' }} Activo
            </span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- SECCIÓN DE MÉTRICAS RESPONSIVA --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">
                <div class="card-stat border-[#41bcb0]">
                    <p class="card-stat-title">Facturado Hoy</p>
                    <h4 class="card-stat-value text-xl sm:text-2xl">${{ number_format($facturadoDiario, 2) }}</h4>
                </div>
                <div class="card-stat border-[#1e3d6c]">
                    <p class="card-stat-title">Total del Mes</p>
                    <h4 class="card-stat-value text-xl sm:text-2xl">${{ number_format($ingresosMes, 2) }}</h4>
                </div>
                <div class="card-stat border-orange-400">
                    <p class="card-stat-title">Reparaciones Mes</p>
                    <h4 class="card-stat-value text-xl sm:text-2xl">{{ $equiposReparadosMes }} <span class="text-xs text-gray-400">Equipos</span></h4>
                </div>
            </div>

            {{-- BOTÓN DE INGRESO --}}
            <div class="mb-10">
                <a href="{{ route('equipos.create') }}" class="btn-zenith block sm:inline-block text-center">
                    Nuevo Ingreso
                </a>
            </div>

            {{-- GRÁFICO PRO RESPONSIVO --}}
            @if(auth()->user()->subscribedToPrice(config('services.stripe.pro_price_id'), 'default'))
                <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-xl mb-10 border-b-4 border-[#1e3d6c]">
                    <h3 class="font-black text-lg sm:text-xl uppercase tracking-tighter mb-6">Rendimiento Semanal</h3>
                    <div class="h-48 sm:h-64">
                        <canvas id="hecChart"></canvas>
                    </div>
                </div>
            @endif

            {{-- TABLA RESPONSIVA --}}
            <div class="card-zenith-form p-4 sm:p-8"> {{-- Usamos tu clase de tarjeta --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr>
                                {{-- Alineaciones y anchos estructurales --}}
                                <th class="table-zenith-head text-left">Modelo / Cliente</th>
                                <th class="table-zenith-head">Presupuesto</th>
                                <th class="table-zenith-head">Estado</th>
                                <th class="table-zenith-head text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse(auth()->user()->equipos()->where('estado', '!=', 'entregado')->get() as $equipo)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    {{-- Datos principales --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black uppercase">{{ $equipo->modelo }}</div>
                                        <div class="text-[10px] text-[#41bcb0] font-bold uppercase">{{ $equipo->name_client }}</div>
                                    </td>

                                    {{-- Presupuesto --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-black text-[#1e3d6c]">
                                            ${{ number_format($equipo->costo, 2) }}
                                        </span>
                                    </td>

                                    {{-- Estado (Usando tu badge del CSS) --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="badge-zenith badge-zenith-amber">{{ $equipo->estado }}</span>
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end items-center gap-4">
                                            {{-- Ticket --}}
                                            <a href="{{ route('equipos.ticket', $equipo->id) }}" target="_blank" class="text-[#41bcb0] hover:opacity-75 transition-opacity">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                </svg>
                                            </a>

                                            {{-- Botón Entregar (Usando tu clase btn-zenith pero compacta) --}}
                                            <livewire:acciones-equipo :equipoId="$equipo->id" :wire:key="'entrega-'.$equipo->id" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- ESTADO VACÍO DE LA TABLA --}}
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="bi bi-clipboard-x text-5xl text-gray-200 mb-4"></i>
                                            <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">No hay equipos ingresados en taller</p>
                                            <p class="text-gray-300 text-[9px] uppercase mt-1 italic">Todo está al día por aquí.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(auth()->user()->subscribedToPrice(config('services.stripe.pro_price_id'), 'default'))
            <div class="mt-12 flex justify-center">
                <a href="{{ route('reporte.mensual') }}" class="btn-reporte-grande">
                    <div class="flex items-center gap-4">
                        <i class="bi bi-file-earmark-pdf-fill text-2xl"></i>
                        <div class="text-left">
                            <span class="block text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Finalizar Ciclo</span>
                            <span class="block text-sm font-black uppercase">Descargar Balance Mensual</span>
                        </div>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
    {{-- SCRIPTS (Solo el JS necesario) --}}
    @if(auth()->user()->subscribedToPrice(config('services.stripe.pro_price_id'), 'default'))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('hecChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($etiquetasDias).map(dia => {
                        const d = dia.trim();
                        return d.charAt(0).toUpperCase() + d.substring(1, 3).toLowerCase();
                    }),
                        datasets: [{
                            data: @json($datosGrafico),
                            borderColor: '#41bcb0',
                            backgroundColor: 'rgba(65, 188, 176, 0.1)',
                            borderWidth: 4,
                            pointBackgroundColor: '#1e3d6c',
                            tension: 0.4,
                            fill: true,
                            spanGaps: true // Conecta puntos aunque falten días
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>
    