<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Equipo: ') }} {{ $equipo->modelo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="modelo" value="{{ __('Modelo del Equipo') }}" />
                            <x-input id="modelo" class="block mt-1 w-full" type="text" name="modelo" :value="old('modelo', $equipo->modelo)" required autofocus />
                        </div>

                        <div>
                            <x-label for="costo" value="{{ __('Costo del Servicio ($)') }}" />
                            <x-input id="costo" class="block mt-1 w-full" type="number" name="costo" step="0.01" :value="old('costo', $equipo->costo)" required />
                        </div>

                        <div class="md:col-span-2">
                            <x-label for="falla" value="{{ __('Descripción de la Falla') }}" />
                            <textarea id="falla" name="falla" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3" required>{{ old('falla', $equipo->falla) }}</textarea>
                        </div>

                        <div>
                            <x-label for="estado" value="{{ __('Estado del Equipo') }}" />
                            <select id="estado" name="estado" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="ingresado" {{ $equipo->estado == 'ingresado' ? 'selected' : '' }}>En Taller (Ingresado)</option>
                                <option value="entregado" {{ $equipo->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-4">
                        <a href="{{ route('equipos.index') }}" class="text-sm text-gray-600 hover:underline">
                            {{ __('Cancelar') }}
                        </a>
                        <x-button class="bg-indigo-600">
                            {{ __('Actualizar Registro') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>