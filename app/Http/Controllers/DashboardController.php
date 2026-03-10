<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Variables de Stripe que ya tenías
        $priceBasico = env('STRIPE_PRICE_BASIC', 'price_1T1fCIJorkeXUUtTFL09xiXi'); 
        $pricePro    = env('STRIPE_PRICE_PRO', 'price_1T1fHwJorkeXUUtTqKqSynBM');

        // 1. MÉTRICAS NUEVAS
        $facturadoDiario = $user->equipos()
            ->where('estado', 'entregado')
            ->whereDate('fecha_entrega', Carbon::today())
            ->sum('costo');

        $equiposReparadosMes = $user->equipos()
            ->where('estado', 'entregado')
            ->whereMonth('fecha_entrega', now()->month)
            ->whereYear('fecha_entrega', now()->year)
            ->count();

        // 2. LÓGICA DEL GRÁFICO (Mejorada para español)
        $etiquetasDias = [];
        $datosGrafico = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i);
            // 'D' nos da Lun, Mar, Mié en español si el locale está en 'es'
            // En lugar de translatedFormat, usa esto que es más directo:
            $etiquetasDias[] = ucfirst($fecha->locale('es')->dayName) . ' ' . $fecha->format('d');
            
            $datosGrafico[] = $user->equipos()
                ->where('estado', 'entregado')
                ->whereDate('fecha_entrega', $fecha->toDateString())
                ->sum('costo');
        }

        // 3. INGRESOS DEL MES (Ya lo tenías)
        $ingresosMes = $user->equipos()
                ->where('estado', 'entregado')
                ->whereMonth('fecha_entrega', now()->month)
                ->whereYear('fecha_entrega', now()->year)
                ->sum('costo');

        // 4. FACTURAS DE STRIPE
        try {
            $invoices = $user->subscribed('default') ? $user->invoices() : collect();
        } catch (\Exception $e) {
            $invoices = collect();
        }

        return view('dashboard', compact(
            'user', 
            'priceBasico', 
            'pricePro', 
            'etiquetasDias', 
            'datosGrafico', 
            'invoices',
            'ingresosMes',
            'facturadoDiario',      // <--- Nueva
            'equiposReparadosMes'   // <--- Nueva
        ));
    }
}