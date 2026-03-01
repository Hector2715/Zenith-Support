<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EquipoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Equipo;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');

// RUTA DEL DASHBOARD
Route::get('dashboard', function () {
    $user = Auth::user();

    $priceBasico = env('STRIPE_PRICE_BASIC', 'price_1T1fCIJorkeXUUtTFL09xiXi'); 
    $pricePro    = env('STRIPE_PRICE_PRO', 'price_1T1fHwJorkeXUUtTqKqSynBM');

    $etiquetasDias = [];
    $datosGrafico = [];

    // Cambiamos a fecha_entrega para que coincida con tu controlador
    for ($i = 6; $i >= 0; $i--) {
        $fecha = Carbon::now()->subDays($i);
        $etiquetasDias[] = $fecha->isoFormat('ddd'); 
        
        // Importante: usamos whereDate con fecha_entrega
        $datosGrafico[] = Equipo::where('estado', 'entregado')
            ->whereDate('fecha_entrega', $fecha->toDateString())
            ->sum('costo');
    }

    // Ingresos del mes usando también fecha_entrega
    $ingresosMes = Equipo::where('estado', 'entregado')
                         ->whereMonth('fecha_entrega', now()->month)
                         ->whereYear('fecha_entrega', now()->year)
                         ->sum('costo');

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
        'ingresosMes'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta de perfil
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rutas de autenticación
require __DIR__.'/auth.php';

// RUTAS PROTEGIDAS
Route::middleware(['auth'])->group(function () {
    // Listado de planes
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/checkout/{plan:slug}', [PlanController::class, 'checkout'])->name('checkout');

    // Gestión de equipos
    Route::get('/equipos/nuevo', [EquipoController::class, 'create'])->name('equipos.create');
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
    Route::patch('/equipos/{equipo}/entregar', [EquipoController::class, 'updateStatus'])->name('equipos.entregar');

    // Reportes
    Route::get('/reporte-mensual', [ReportController::class, 'mensual'])->name('reporte.mensual');

    // RUTAS DE DESCARGA DE FACTURAS (Ahora dentro del grupo correctamente)
    Route::get('/user/invoice/{invoice}', function (Request $request, string $invoiceId) {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => 'HEC TECH',
            'product' => 'Suscripción Mensual',
        ]);
    })->name('invoice.download');
});