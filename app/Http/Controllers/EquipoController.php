<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

class EquipoController extends Controller
{
    // Muestra el formulario de ingreso
    public function create()
    {
        return view('equipos.create');
    }

    // Guarda el equipo en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string|max:255',
            'falla'  => 'required|string',
            'costo'  => 'required|numeric|min:0', // Validación de dinero
        ]);

        Equipo::create([
            'modelo' => $request->modelo,
            'falla'  => $request->falla,
            'costo'  => $request->costo,
            'estado' => 'ingresado',
        ]);

        return redirect()->route('dashboard')->with('status', 'Equipo ingresado con éxito.');
    }

    public function updateStatus(Equipo $equipo)
    {
        // Cambiamos el estado y actualizamos la fecha para el gráfico
        $equipo->update([
            'estado' => 'entregado',
            'fecha_entrega' => now() // Esto es lo que lee el gráfico
        ]);

        return redirect()->route('dashboard')->with('success', '¡Equipo entregado! El gráfico se ha actualizado.');
    }
}
