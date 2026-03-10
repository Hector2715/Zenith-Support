<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipoController extends Controller
{
    // Muestra el formulario de ingreso
    public function create()
    {
        return view('equipos.create');
    }

    // Lista completa para Gestión (Privada)
    public function index()
    {
        $equipos = auth()->user()->equipos()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('equipos.index', compact('equipos'));
    }

    // Formulario de edición (Privado)
    public function edit($id)
    {
        $equipo = auth()->user()->equipos()->find($id);

        if (!$equipo) {
            return redirect()->route('equipos.index')
                ->with('error', 'El equipo solicitado no existe en sus registros.');
        }

        return view('equipos.edit', compact('equipo'));
    }


    // Guardar cambios (Privado)
    public function update(Request $request, $id)
    {
        $equipo = auth()->user()->equipos()->findOrFail($id);

        if (!$equipo) {
            return redirect()->route('equipos.index')
                ->with('error', 'No se puede actualizar un equipo que no le pertenece.');
        }

        $validated = $request->validate([
            'name_client' => 'required|string|max:255',
            'modelo'      => 'required|string|max:255',
            'falla'       => 'required|string',
            'costo'       => 'required|numeric|min:0',
            'estado'      => 'required|in:ingresado,entregado',
        ]);

        // Lógica de fecha de entrega para el gráfico
        if ($validated['estado'] === 'entregado' && $equipo->estado !== 'entregado') {
            $validated['fecha_entrega'] = now();
        } elseif ($validated['estado'] === 'ingresado') {
            $validated['fecha_entrega'] = null;
        }

        $equipo->update($validated);

        return redirect()->route('equipos.index')->with('status', 'Registro actualizado con exito!');
    }

    // Guarda el equipo vinculado al usuario
    public function store(Request $request)
    {
        $request->validate([
            'name_client' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'falla'  => 'required|string',
            'costo'  => 'required|numeric|min:0',
        ]);

        // Usamos la relación para asegurar el user_id
        auth()->user()->equipos()->create([
            'name_client' => $request->name_client,
            'modelo' => $request->modelo,
            'falla'  => $request->falla,
            'costo'  => $request->costo,
            'estado' => 'ingresado',
        ]);

        return redirect()->route('dashboard')->with('status', 'Equipo ingresado con éxito.');
    }

    // Botón rápido de entrega (Privado)
    public function updateStatus($id)
    {
        $equipo = auth()->user()->equipos()->find($id);

        if (!$equipo) {
            return redirect()->route('dashboard')
                ->with('error', 'Operación no permitida.');
        }

        $equipo->update([
            'estado' => 'entregado',
            'fecha_entrega' => now()
        ]);

        return redirect()->route('dashboard')->with('status', '¡Equipo entregado! El gráfico se ha actualizado.');
    }


    // Eliminar registro (Privado)
    public function destroy($id)
    {
        $equipo = auth()->user()->equipos()->find($id);

        if (!$equipo) {
            return redirect()->route('equipos.index')
                ->with('error', 'No se encontró el registro para eliminar.');
        }

        $equipo->delete();
        return redirect()->route('equipos.index')->with('status', 'Equipo eliminado del sistema.');
    }
}