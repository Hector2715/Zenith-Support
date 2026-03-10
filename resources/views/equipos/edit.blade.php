<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="title-zenith">
                {{ __('Editar Registro:') }} <span class="text-[#41bcb0]">{{ $equipo->modelo }}</span>
            </h2>
            <a href="{{ route('equipos.index') }}" class="text-[10px] font-black text-gray-400 hover:text-[#1e3d6c] transition-colors uppercase tracking-[0.2em]">
                &larr; Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="card-zenith-form">
                <div class="p-10">
                    <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.4em] mb-10 text-center">Actualización de Información Técnica</h3>
                    
                    <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Nombre de Cliente --}}
                            <div class="space-y-2">
                                <label class="label-zenith">{{ __('Nombre del Cliente') }}</label>
                                <input type="text" name="name_client" value="{{ old('name_client', $equipo->name_client) }}" 
                                    class="input-zenith" required>
                                <x-input-error :messages="$errors->get('name_client')" class="mt-2 text-[10px] font-bold uppercase" />
                            </div>                            
                            {{-- Modelo --}}
                            <div class="space-y-2">
                                <label class="label-zenith">{{ __('Modelo del Equipo') }}</label>
                                <input type="text" name="modelo" value="{{ old('modelo', $equipo->modelo) }}" 
                                    class="input-zenith" required autofocus>
                                <x-input-error :messages="$errors->get('modelo')" class="mt-2 text-[10px] font-bold uppercase" />
                            </div>

                            {{-- Estado del Equipo --}}
                            <div class="space-y-2">
                                <label class="label-zenith">{{ __('Estado del Equipo') }}</label>
                                <select name="estado" class="input-zenith cursor-pointer bg-white">
                                    <option value="ingresado" {{ old('estado', $equipo->estado) == 'ingresado' ? 'selected' : '' }}>EN TALLER (INGRESADO)</option>
                                    <option value="entregado" {{ old('estado', $equipo->estado) == 'entregado' ? 'selected' : '' }}>ENTREGADO / FINALIZADO</option>
                                </select>
                                <x-input-error :messages="$errors->get('estado')" class="mt-2 text-[10px] font-bold uppercase" />
                            </div>

                            {{-- Descripción de la Falla --}}
                            <div class="md:col-span-2 space-y-2">
                                <label class="label-zenith">{{ __('Descripción de la Falla') }}</label>
                                <textarea name="falla" class="textarea-zenith" rows="3" required>{{ old('falla', $equipo->falla) }}</textarea>
                                <x-input-error :messages="$errors->get('falla')" class="mt-2 text-[10px] font-bold uppercase" />
                            </div>
                        </div>

                        {{-- Contenedor de Presupuesto --}}
                        <div class="budget-container-zenith mt-8">
                            <label class="label-zenith">{{ __('Presupuesto Final ($)') }}</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center font-black text-[#1e3d6c]">$</span>
                                <input name="costo" type="number" step="0.01" value="{{ old('costo', $equipo->costo) }}" 
                                    class="input-budget-zenith" required>
                            </div>
                            <x-input-error :messages="$errors->get('costo')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="flex items-center justify-end mt-10 space-x-6">
                            <a href="{{ route('equipos.index') }}" class="text-[10px] font-black text-gray-400 hover:text-red-500 transition-colors uppercase tracking-widest">
                                {{ __('Descartar Cambios') }}
                            </a>
                            <button type="submit" class="btn-zenith w-auto px-10 py-4">
                                {{ __('Actualizar Registro') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="mt-8 text-center text-[9px] text-gray-400 font-black uppercase tracking-[0.5em]">
                Modificando entrada ID: #{{ $equipo->id }}
            </p>
        </div>
    </div>
</x-app-layout>