<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Equipo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('equipos.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="modelo" :value="__('Modelo del Equipo')" />
                        <x-text-input id="modelo" name="modelo" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="falla" :value="__('Descripción de la Falla')" />
                        <textarea id="falla" name="falla" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required></textarea>
                    </div>
                    <div class="mb-4">
					    <x-input-label for="costo" :value="__('Costo de Reparación ($)')" />
					    <x-text-input id="costo" name="costo" type="number" step="0.01" class="mt-1 block w-full" placeholder="0.00" required />
					</div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>
                            {{ __('Guardar Ingreso') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>