<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Equipos') }}
        </h2>
    </x-slot>
	<div class="py-12">
	    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
	        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
	            <h2 class="text-2xl font-bold mb-6">Panel de Gestión de Equipos</h2>

	            <table class="min-w-full divide-y divide-gray-200">
	                <thead class="bg-gray-50">
	                    <tr>
	                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Modelo</th>
	                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
	                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Costo</th>
	                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
	                    </tr>
	                </thead>
	                <tbody class="bg-white divide-y divide-gray-200">
	                    @foreach($equipos as $equipo)
	                    <tr>
	                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $equipo->modelo }}</td>
	                        <td class="px-6 py-4 whitespace-nowrap">
	                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $equipo->estado == 'ingresado' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
	                                {{ strtoupper($equipo->estado) }}
	                            </span>
	                        </td>
	                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($equipo->costo, 2) }}</td>
	                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
	                            @if($equipo->estado !== 'entregado')
	                                <form action="{{ route('equipos.entregar', $equipo) }}" method="POST" class="inline">
	                                    @csrf @method('PATCH')
	                                    <button class="text-green-600 hover:text-green-900">Entregar</button>
	                                </form>
	                            @endif

	                            <a href="{{ route('equipos.edit', $equipo) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>

	                            <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este ingreso?')">
	                                @csrf @method('DELETE')
	                                <button class="text-red-600 hover:text-red-900">Eliminar</button>
	                            </form>
	                        </td>
	                    </tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</x-app-layout>