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

    // Lista completa para Gestión
    public function index()
    {
        $equipos = Equipo::orderBy('created_at', 'desc')->get();
        return view('equipos.index', compact('equipos'));
    }

    // Formulario de edición
    public function edit(Equipo $equipo)
    {
        return view('equipos.edit', compact('equipo'));
    }

    // Guardar cambios
    public function update(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'modelo' => 'required|string|max:255',
            'falla'  => 'required|string',
            'costo'  => 'required|numeric|min:0',
            'estado' => 'required|in:ingresado,entregado',
        ]);

        $equipo->update($validated);

        return redirect()->route('equipos.index')->with('status', 'Registro actualizado con éxito.');
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

        // Eliminar registro
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();
        return redirect()->route('equipos.index')->with('status', 'Equipo eliminado del sistema.');
    }
}
