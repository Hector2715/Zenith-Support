<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use App\Notifications\SendOTPNotification; // Asegúrate de haber creado la notificación

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';
    
    // Nuevas propiedades para el OTP
    public string $otp_input = '';
    public bool $otpSent = false;

    /**
     * Paso 1: Generar y enviar el OTP al correo
     */
    public function sendOTP(): void
    {
        $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
        ]);

        $user = Auth::user();
        $otp = rand(100000, 999999);

        // Guardamos en la base de datos (requiere la migración que hicimos)
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Ahora enviamos
    try {
        $user->notify(new SendOTPNotification($otp));
        $this->otpSent = true;
    } catch (\Exception $e) {
        $this->addError('current_password', 'Error de envío, pero el código es: ' . $otp);
    }
    }

    /**
     * Paso 2: Validar OTP y actualizar la contraseña
     */
    public function updatePassword(): void
    {
        $user = Auth::user();

        try {
            $validated = $this->validate([
                'otp_input' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                    if ($value != $user->otp_code || now()->isAfter($user->otp_expires_at)) {
                        $fail(__('El código OTP es inválido o ha expirado.'));
                    }
                }],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('password', 'password_confirmation', 'otp_input');
            throw $e;
        }

        $user->update([
            'password' => Hash::make($validated['password']),
            'otp_code' => null, // Limpiamos después de usar
            'otp_expires_at' => null,
        ]);

        $this->reset('current_password', 'password', 'password_confirmation', 'otp_input', 'otpSent');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="{{ $otpSent ? 'updatePassword' : 'sendOTP' }}" class="mt-6 space-y-6">
        
        @if(!$otpSent)
            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>
                    {{ __('Enviar código de verificación') }}
                </x-primary-button>
            </div>
        @else
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-100">
                {{ __('Se ha enviado un código de 6 dígitos a tu correo electrónico.') }}
            </div>

            <div>
                <x-input-label for="otp_input" :value="__('Código de Verificación (OTP)')" />
                <x-text-input wire:model="otp_input" id="otp_input" type="text" class="mt-1 block w-full font-mono text-center text-xl tracking-widest" placeholder="000000" maxlength="6" />
                <x-input-error :messages="$errors->get('otp_input')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Actualizar Contraseña') }}</x-primary-button>
                
                <button type="button" wire:click="$set('otpSent', false)" class="text-sm text-gray-600 dark:text-gray-400 underline">
                    {{ __('Volver') }}
                </button>
            </div>
        @endif

        <x-action-message class="me-3" on="password-updated">
            {{ __('Contraseña actualizada correctamente.') }}
        </x-action-message>
    </form>
</section>