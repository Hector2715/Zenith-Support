<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-black text-2xl text-[#1e3d6c] leading-tight uppercase tracking-tighter">
                {{ __('Gestión de Equipos') }}
            </h2>

            <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                <a href="{{ route('dashboard') }}" class="flex-1 sm:flex-none text-center bg-gray-200 hover:bg-gray-300 text-[#1e3d6c] text-[10px] font-black py-2.5 px-6 rounded-lg transition-all uppercase tracking-widest">
                    &larr; Volver
                </a>
                <a href="{{ route('equipos.create') }}" class="flex-1 sm:flex-none text-center bg-[#41bcb0] hover:bg-[#1e3d6c] text-white text-[10px] font-black py-2.5 px-6 rounded-lg transition-all uppercase tracking-widest shadow-lg">
                    + Ingreso Nuevo 
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SECCIÓN DE FILTROS Y BÚSQUEDA RESPONSIVA --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                {{-- Buscador --}}
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="BUSCAR EQUIPO O CLIENTE..." 
                        class="w-full border-none shadow-md rounded-xl p-4 text-[10px] font-black tracking-widest text-[#1e3d6c] focus:ring-2 focus:ring-[#41bcb0] uppercase">
                    <span class="absolute right-4 top-4 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                </div>

                {{-- Filtro de Estado --}}
                <select id="statusFilter" class="w-full border-none shadow-md rounded-xl p-4 text-[10px] font-black tracking-widest text-[#1e3d6c] focus:ring-2 focus:ring-[#41bcb0] uppercase cursor-pointer">
                    <option value="">TODOS LOS ESTADOS</option>
                    <option value="ingresado">EN TALLER</option>
                    <option value="entregado">ENTREGADOS</option>
                </select>

                {{-- Resumen Rápido (Oculto en móvil pequeño para ahorrar espacio, o full width) --}}
                <div class="bg-[#1e3d6c] rounded-xl p-4 flex items-center justify-center shadow-md sm:col-span-2 lg:col-span-1">
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">
                        Total registros: {{ $equipos->count() }}
                    </span>
                </div>
            </div>

            {{-- TABLA PRINCIPAL RESPONSIVA --}}
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl border-t-4 border-[#1e3d6c]">
                <div class="p-4 sm:p-8">
                    <h3 class="hidden sm:block text-sm font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Panel de Control General</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 lg:table-fixed">
                            <thead>
                                <tr>
                                    <th class="table-zenith-head text-left">Equipo / Cliente</th>
                                    <th class="table-zenith-head text-center">Estado</th>
                                    <th class="table-zenith-head text-center">Presupuesto</th>
                                    <th class="table-zenith-head text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($equipos as $equipo)
                                <tr class="equipo-row hover:bg-slate-50 transition-colors" 
                                    data-info="{{ strtolower($equipo->modelo . ' ' . $equipo->name_client) }}"
                                    data-status="{{ strtolower($equipo->estado) }}">
                                    
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-[#1e3d6c] uppercase">{{ $equipo->modelo }}</div>
                                        <div class="text-[10px] text-[#41bcb0] font-bold uppercase tracking-tighter">
                                            {{ $equipo->name_client ?? 'Sin Registro' }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        <span class="badge-zenith {{ $equipo->estado == 'entregado' ? 'badge-zenith-teal' : 'badge-zenith-amber' }}">
                                            {{ $equipo->estado }}
                                        </span>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        <span class="text-sm font-black text-[#1e3d6c]">${{ number_format($equipo->costo, 2) }}</span>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="flex justify-end items-center gap-1 sm:gap-3 action-container">
                                            {{-- Ticket --}}
                                            <a href="{{ route('equipos.ticket', $equipo->id) }}">
                                                <i class="bi bi-printer-fill"></i>
                                            </a>

                                            {{-- Editar --}}
                                            <a href="{{ route('equipos.edit', $equipo->id) }}"> 
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Eliminar --}}
                                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar registro?')">
                                                @csrf @method('DELETE')
                                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                   <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">No hay registros</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const rows = document.querySelectorAll('.equipo-row');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusTerm = statusFilter.value.toLowerCase();

                rows.forEach(row => {
                    const info = row.getAttribute('data-info');
                    const status = row.getAttribute('data-status');
                    
                    const matchesSearch = info.includes(searchTerm);
                    const matchesStatus = statusTerm === "" || status === statusTerm;

                    row.style.display = (matchesSearch && matchesStatus) ? "" : "none";
                });
            }

            searchInput.addEventListener('input', filterTable); // 'input' es mejor que 'keyup' para móviles
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
</x-app-layout>