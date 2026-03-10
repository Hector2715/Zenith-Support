<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-center justify-between">
            <h2 class="title-zenith">
                {{ __('Registrar Nuevo Equipo') }}
            </h2>
            <a href="{{ route('equipos.index') }}" class="text-[10px] font-black text-gray-400 hover:text-[#1e3d6c] transition-colors uppercase tracking-[0.2em]">
                &larr; Cancelar
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="card-zenith-form">
                <div class="p-6 sm:p-10">
                    <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.4em] mb-10 text-center">Ingreso Técnico</h3>

                    <form action="{{ route('equipos.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="label-zenith">Nombre del Cliente</label>
                                <input name="name_client" type="text" class="input-zenith" placeholder="EJ: JUAN PÉREZ" required>
                            </div>

                            <div>
                                <label class="label-zenith">Modelo / Dispositivo</label>
                                <input name="modelo" type="text" class="input-zenith" placeholder="EJ: IPHONE 13 PRO MAX" required>
                            </div>
                        </div>

                        <div>
                            <label class="label-zenith">Descripción de la Falla</label>
                            <textarea name="falla" class="textarea-zenith" rows="4" placeholder="DETALLE EL PROBLEMA TÉCNICO..." required></textarea>
                        </div>

                        <div class="budget-container-zenith">
                            <label class="label-zenith">Presupuesto Estimado</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center font-black text-[#1e3d6c]">$</span>
                                <input name="costo" type="number" step="0.01" class="input-budget-zenith" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-center pt-6">
                            <button type="submit" class="btn-zenith w-full sm:w-auto px-12 py-4">
                                {{ __('Guardar en Registro') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>