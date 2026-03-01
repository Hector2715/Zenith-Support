<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads; //

new class extends Component
{
    use WithFileUploads; // Habilitamos la subida de archivos

    public string $name = '';
    public string $email = '';
    public $avatar; // Nueva propiedad para la imagen

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'], // Validación de imagen (2MB máx)
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Lógica para guardar el avatar si se subió uno nuevo
        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send email verification.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informacion de Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Actualice la información del perfil y la dirección de correo electrónico de su cuenta.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div class="flex items-center gap-6">
            <div class="shrink-0">
                @if ($avatar)
                    <img class="h-16 w-16 object-cover rounded-full" src="{{ $avatar->temporaryUrl() }}" alt="Preview">
                @elseif (auth()->user()->avatar)
                    <img class="h-16 w-16 object-cover rounded-full" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">
                @else
                    <div class="h-16 w-16 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            
            <div>
                <x-input-label for="avatar" :value="__('Foto de Perfil')" />
                
                @if ($avatar)
                    <div class="mt-2 mb-4">
                        <p class="text-xs text-gray-500 mb-1">Vista previa:</p>
                        <img src="{{ $avatar->temporaryUrl() }}" class="h-20 w-20 rounded-full object-cover border-2 border-indigo-500 shadow-sm">
                    </div>
                @elseif (auth()->user()->avatar_url) {{-- Asumiendo que guardas la URL --}}
                    <div class="mt-2 mb-4">
                        <img src="{{ auth()->user()->avatar_url }}" class="h-20 w-20 rounded-full object-cover">
                    </div>
                @endif

                <input wire:model="avatar" type="file" id="avatar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                
                <div wire:loading wire:target="avatar" class="text-sm text-gray-500 mt-2">
                    <span class="animate-pulse">⏳</span> {{ __('Subiendo...') }}
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Su dirección de correo electrónico no está verificada.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Guardado.') }}
            </x-action-message>
        </div>
    </form>
</section>