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
    public string $nombre_taller = '';
    public string $email = '';
    public $avatar; // Nueva propiedad para la imagen

    /**
     * Mount the component.
     */
    public function mount(): void
    {   
        $user = Auth::user();
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->nombre_taller = Auth::user()->nombre_taller ?? '';
    }

    /**
     * Update the profile information.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nombre_taller' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'], 
        ]);

        $user->forceFill([
                'name' => $this->name,
                'email' => $this->email,
                'nombre_taller' => $this->nombre_taller,
            ]);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Guardar el avatar
        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // IMPORTANTE: Limpiamos la propiedad temporal para refrescar la vista real
        $this->reset('avatar');

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
            {{ __("Actualice la información de su taller y su cuenta de usuario.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div class="flex items-center gap-6">
            <div class="shrink-0 relative">
                @if ($avatar)
                    <img class="h-16 w-16 object-cover rounded-full border-2 border-indigo-500" src="{{ $avatar->temporaryUrl() }}">
                @elseif (auth()->user()->avatar)
                    <img class="h-16 w-16 object-cover rounded-full" src="{{ asset('storage/' . auth()->user()->avatar) }}">
                @else
                    <div class="h-16 w-16 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif

                <div wire:loading wire:target="avatar" class="absolute inset-0 bg-black bg-opacity-25 rounded-full flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="flex-1">
                <x-input-label for="avatar" :value="__('Logo del Taller')" />
                <input wire:model="avatar" type="file" id="avatar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div>
            <x-input-label for="nombre_taller" :value="__('Nombre de tu Taller')" />
            <x-text-input wire:model="nombre_taller" id="nombre_taller" type="text" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('nombre_taller')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button wire:loading.attr="disabled" wire:target="updateProfileInformation">
                <span wire:loading.remove wire:target="updateProfileInformation">
                    {{ __('Guardar cambios') }}
                </span>
                <span wire:loading wire:target="updateProfileInformation" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Guardando...') }}
                </span>
            </x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('¡Guardado con éxito!') }}
            </x-action-message>
        </div>
    </form>
</section>