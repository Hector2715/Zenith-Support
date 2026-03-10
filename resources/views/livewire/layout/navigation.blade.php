<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

@php
    // Definimos los IDs desde la configuración para que funcione en producción
    $proId = config('services.stripe.pro_price_id');
    $basicId = config('services.stripe.basic_price_id');
    $user = auth()->user();
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-2">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="block h-10 w-auto rounded-lg shadow-sm">
                        @else
                            <x-application-logo class="block h-10 w-auto fill-current text-indigo-600" />
                        @endif

                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('plans.index')" :active="request()->routeIs('plans.index')" wire:navigate>
                        {{ __('Planes') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('equipos.index')" :active="request()->routeIs('equipos.index')">
                        {{ __('Gestión de Equipos') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full overflow-hidden border border-gray-200 me-2 shadow-sm">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full bg-indigo-500 text-white font-bold text-xs uppercase">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <div x-data="{{ json_encode(['name' => $user->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name">
                                </div>

                                {{-- LÓGICA DE BADGES POR NIVELES --}}
                                    @if($user->subscribed('default') && $proId && $user->subscribedToPrice($proId, 'default'))
                                        {{-- NIVEL 3: PRO --}}
                                        <span class="ms-2 px-2 py-0.5 text-[10px] bg-amber-100 text-amber-700 font-black rounded-full border border-amber-200 uppercase tracking-tighter shadow-sm">
                                            PRO
                                        </span>
                                    @elseif($user->subscribed('default') && $basicId && $user->subscribedToPrice($basicId, 'default'))
                                        {{-- NIVEL 2: BASIC --}}
                                        <span class="ms-2 px-2 py-0.5 text-[10px] bg-green-100 text-green-700 font-black rounded-full border border-green-200 uppercase tracking-tighter shadow-sm">
                                            BASIC
                                        </span>
                                    @else
                                        {{-- NIVEL 1: ESTÁNDAR (POR DEFECTO) --}}
                                        <span class="ms-2 px-2 py-0.5 text-[10px] bg-gray-100 text-gray-500 font-bold rounded-full border border-gray-200 uppercase tracking-tighter">
                                            ESTÁNDAR
                                        </span>
                                    @endif
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                <div class="h-10 w-10 rounded-full overflow-hidden border border-gray-300 me-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full bg-indigo-500 text-white font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => $user->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-gray-500">{{ $user->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>