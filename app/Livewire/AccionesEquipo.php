<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipo;

class AccionesEquipo extends Component
{
    public $equipoId;

    public function mount($equipoId)
    {
        $this->equipoId = $equipoId;
    }

    public function entregar()
    {
        $equipo = auth()->user()->equipos()->find($this->equipoId);

        if ($equipo) {
            $equipo->update([
                'estado' => 'entregado',
                'fecha_entrega' => now()
            ]);

            session()->flash('status', '¡Equipo entregado con éxito!');
            
            // Aquí está el truco: el navigate: true activa la barra superior
            return $this->redirectRoute('dashboard', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.acciones-equipo');
    }
}