<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Zenith Support') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SECCIÓN PARA USUARIOS SUSCRITOS --}}
            @if(auth()->user()->subscribed('default'))
                
                {{-- GRID SUPERIOR: GESTIÓN Y GRÁFICO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    {{-- Tarjeta: Gestión de equipos --}}
                    <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500 flex flex-col justify-between text-left">
                        <div>
                            <h3 class="font-bold text-lg mb-2 text-gray-800 italic">🛠️ Gestión de Reparaciones</h3>
                            <p class="text-gray-600 mb-4">Registra ingresos y controla el flujo de tu taller en tiempo real.</p>
                        </div>
                        <div>
                            <a href="{{ route('equipos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-black inline-block transition shadow-md uppercase tracking-wider">
                                Nuevo Ingreso
                            </a>
                        </div>
                    </div>

                    {{-- Tarjeta: Gráfico (Solo Pro) --}}
                    @if(auth()->user()->subscribedToPrice($pricePro, 'default'))
                        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-600">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 italic">📊 Rendimiento Semanal</h3>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold">Equipos entregados</p>
                                </div>
                                {{-- Muestra los ingresos calculados en web.php --}}
                                <div class="text-right">
                                    <span class="block text-2xl font-black text-indigo-700">${{ number_format($ingresosMes, 2) }}</span>
                                    <span class="text-[10px] uppercase font-bold text-gray-400">Ingresos Mes</span>
                                </div>
                            </div>
                            <div class="h-48">
                                <canvas id="hecChart"></canvas>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-6 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
                            <span class="text-4xl mb-2">🔒</span>
                            <p class="text-gray-500 text-sm">Las métricas de rendimiento son exclusivas del <b>Plan Pro</b></p>
                            <a href="{{ route('plans.index') }}" class="mt-3 text-blue-600 font-bold text-xs uppercase underline hover:text-blue-800">Mejorar Cuenta</a>
                        </div>
                    @endif

                {{-- TABLA: EQUIPOS EN TALLER --}}
                <div class="mb-8 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-t-4 border-yellow-400">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-xl text-gray-800 uppercase tracking-tighter">Equipos en Taller</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-black px-3 py-1 rounded-full border border-yellow-200 uppercase">
                            {{ App\Models\Equipo::where('estado', '!=', 'entregado')->count() }} Pendientes
                        </span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Modelo</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse(App\Models\Equipo::where('estado', '!=', 'entregado')->get() as $equipo)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $equipo->modelo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full bg-yellow-100 text-yellow-800 uppercase border border-yellow-200">
                                                {{ $equipo->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <form action="{{ route('equipos.entregar', $equipo) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded-md font-bold text-xs shadow-sm transition uppercase">
                                                    Entregar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="text-4xl mb-2">☕</span>
                                                <p class="text-gray-500 italic font-medium">No hay equipos pendientes. ¡Hora de un café!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- BANNER PRO: REPORTES --}}
                @if(auth()->user()->subscribedToPrice($pricePro, 'default'))
                    <div class="mb-8 bg-gradient-to-r from-indigo-900 to-blue-900 text-white p-6 rounded-xl shadow-2xl flex flex-col md:flex-row justify-between items-center border-b-4 border-indigo-500">
                        <div class="mb-4 md:mb-0 text-center md:text-left">
                            <h3 class="text-2xl font-black italic tracking-tighter">Reportes Inteligentes</h3>
                            <p class="text-indigo-200 text-sm">Genera informes técnicos y comprobantes en PDF con un clic.</p>
                        </div>
                        <a href="{{ route('reporte.mensual') }}" class="bg-white text-indigo-900 px-8 py-3 rounded-full font-black text-xs uppercase shadow-xl hover:scale-105 transition-transform inline-block text-center">
                            Generar Reporte Mensual
                        </a>
                    </div>
                @endif

                {{-- HISTORIAL DE PAGOS --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border-t-4 border-gray-200">
                    <h3 class="text-lg font-black mb-6 text-gray-800 uppercase tracking-widest">Facturación</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Monto</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-bold text-gray-500 uppercase">Documento</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($invoices as $invoice)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm">{{ $invoice->date()->toFormattedDateString() }}</td>
                                        <td class="px-6 py-4 text-sm font-bold">{{ $invoice->total() }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('invoice.download', $invoice->id) }}" class="text-blue-600 hover:text-blue-900 font-bold text-xs uppercase tracking-tighter">
                                                Descargar PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                {{-- VISTA SIN SUSCRIPCIÓN --}}
                <div class="bg-white p-12 rounded-2xl shadow-2xl text-center border-b-8 border-blue-600">
                    <div class="flex justify-center mb-6">
                        <x-application-logo class="h-24 w-auto" />
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 italic">¡Hola, {{ auth()->user()->name }}!</h2>
                    <p class="text-gray-500 mt-4 mb-8 text-lg max-w-md mx-auto">Para comenzar a gestionar tu taller con <b>Zenith Support</b>, necesitas activar un plan de suscripción.</p>
                    <a href="{{ route('plans.index') }}" class="bg-blue-600 text-white px-12 py-4 rounded-full font-black text-sm uppercase tracking-widest shadow-lg hover:bg-blue-700 hover:shadow-2xl transition-all inline-block">
                        Ver Planes Disponibles
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- SCRIPTS --}}
    @if(auth()->user()->subscribedToPrice($pricePro, 'default'))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('hecChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($etiquetasDias),
                    datasets: [{
                        label: 'Ingresos Zenith Support', // Nombre más descriptivo
                        data: @json($datosGrafico),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#4f46e5',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                // Esto hace que al pasar el mouse veas: "Ingresos Zenith Support: $50.00"
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { 
                                // ELIMINADO: stepSize: 1 (esto era lo que rompe el dinero)
                                color: '#94a3b8',
                                callback: function(value) {
                                    return '$' + value; // Añade el $ al eje lateral
                                }
                            }, 
                            grid: { borderDash: [5, 5] } 
                        },
                        x: { 
                            grid: { display: false }, 
                            ticks: { color: '#94a3b8' } 
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>