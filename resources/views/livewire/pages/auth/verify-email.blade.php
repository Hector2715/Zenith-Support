<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Ingresa el código de 6 dígitos enviado a tu correo para activar tu cuenta de Zunith Support.') }}
    </div>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <div>
            <x-input-label for="code" :value="__('Código de Verificación')" />
            
            <x-text-input id="code" 
                         class="block mt-1 w-full text-center text-3xl font-bold tracking-widest" 
                         type="text" 
                         name="code" 
                         required 
                         autofocus />

            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <x-primary-button>
                {{ __('Verificar Código') }}
            </x-primary-button>

            <button type="submit" form="logout-form" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Cerrar Sesión') }}
            </button>
        </div>
    </form>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
</x-guest-layout>