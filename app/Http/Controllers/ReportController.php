<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function mensual()
    {

        if (!auth()->user()->subscribed()) {
        return redirect()->route('plans.index')
            ->with('error', 'Los reportes detallados en PDF son una función exclusiva de Zunith PRO.');
    }

        // Solo equipos que pertenecen al usuario logueado
        $equipos = auth()->user()->equipos()
                    ->where('estado', 'entregado')
                    ->whereMonth('fecha_entrega', now()->month)
                    ->whereYear('fecha_entrega', now()->year) // Añade el año para evitar mezclar con años pasados
                    ->get();

        $totalMes = $equipos->sum('costo');
        
        $pdf = Pdf::loadView('reportes.mensual', compact('equipos'));

        return $pdf->download('reporte-mensual-' . now()->format('m-Y') . '.pdf');
    }

    public function generarTicket(Equipo $equipo)
    {
        // Verificamos que el equipo pertenezca al usuario y que tenga plan Basic o Pro
        if ($equipo->user_id !== auth()->id() || !auth()->user()->subscribed('default')) {
            abort(403, 'Función exclusiva para planes activos de Zenith Support.');
        }

        // Configuramos el papel para ticket (80mm de ancho x altura variable según contenido)
        // 226pt es aprox 80mm
        $pdf = Pdf::loadView('reportes.ticket', compact('equipo'))
                  ->setPaper([0, 0, 226, 500], 'portrait'); 

        return $pdf->stream('ticket-' . $equipo->id . '.pdf');
    }
}
