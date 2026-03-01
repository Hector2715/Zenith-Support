<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function mensual()
    {
        // Obtenemos los equipos entregados este mes
        $equipos = Equipo::where('estado', 'entregado')
                         ->whereMonth('fecha_entrega', now()->month)
                         ->get();

        $totalMes = $equipos->sum('costo');
        
        // Cargamos una vista que diseñaremos para el PDF
        $pdf = Pdf::loadView('reportes.mensual', compact('equipos'));

        // Retornamos el PDF para descargar
        return $pdf->download('reporte-mensual' . now()->format('m-Y') . '.pdf');
    }
}
