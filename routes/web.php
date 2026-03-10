<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\OtpController;
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

// RUTAS DE VERIFICACIÓN OTP (Fuera del middleware 'verified')
Route::middleware(['auth'])->group(function () {
    Route::get('/verificar-cuenta', [OtpController::class, 'show'])->name('otp.view');
    Route::post('/verificar-cuenta', [OtpController::class, 'verify'])->name('otp.verify');
});

// RUTA DEL DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

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
    Route::get('/gestion-equipos', [EquipoController::class, 'index'])->name('equipos.index');
    Route::get('/equipos/{equipo}/editar', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::put('/equipos/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
    Route::patch('/equipos/{equipo}/entregar', [EquipoController::class, 'updateStatus'])->name('equipos.entregar');

    // Reportes
    Route::get('/equipos/{equipo}/ticket', [ReportController::class, 'generarTicket'])->name('equipos.ticket');
    Route::get('/reporte-mensual', [ReportController::class, 'mensual'])->name('reporte.mensual');

    // RUTAS DE DESCARGA DE FACTURAS (Ahora dentro del grupo correctamente)
    Route::get('/user/invoice/{invoice}', function (Request $request, string $invoiceId) {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => 'HEC TECH',
            'product' => 'Suscripción Mensual',
        ]);
    })->name('invoice.download');

    //Legal
    Route::get('/terminos', [LegalController::class, 'terminos'])->name('legal.terminos');
    Route::get('/privacidad', [LegalController::class, 'privacidad'])->name('legal.privacidad');
    Route::get('/soporte', [LegalController::class, 'soporte'])->name('legal.soporte');
    Route::post('/soporte/enviar', [SupportController::class, 'send'])->name('soporte.send');
});