@extends('layouts.pdf')

@section('content')
<style>
    /* Sobrescribimos el tamaño para Reporte A4 */
    body { font-size: 12px; padding: 20px; }
    
    table th { 
        font-size: 11px; 
        padding: 12px; 
        background-color: #1e3d6c; 
        color: white; 
        border: none;
    }
    
    table td { 
        font-size: 12px; 
        padding: 12px; 
        border-bottom: 1px solid #e2e8f0; 
        border-left: none; 
        border-right: none; 
    }

    .total-section {
        margin-top: 40px;
        padding: 25px;
        background: #f8fafc;
        border-left: 6px solid #41bcb0;
        text-align: right;
    }

    .total-amount {
        font-size: 28px;
        color: #1e3d6c;
        display: block;
        font-weight: 900;
    }
</style>

<div style="padding: 10px;">
    <div style="border-bottom: 3px solid #1e3d6c; padding-bottom: 15px; margin-bottom: 20px;">
        @if(auth()->user()->avatar)
            <img src="{{ public_path('storage/' . auth()->user()->avatar) }}" 
                 style="width: 60px; height: 60px; float: left; margin-right: 15px; border-radius: 10px;">
        @endif
        <div style="float: left;">
            <h1 class="text-navy uppercase font-black" style="margin: 0; font-size: 20px;">{{ auth()->user()->nombre_taller ?? 'Zenith Support' }}</h1>
            <p class="text-teal font-black uppercase" style="margin: 0; font-size: 11px;">Reporte Mensual de Ingresos</p>
            <p style="margin: 0; font-size: 10px;">Período: {{ ucfirst(\Illuminate\Support\Carbon::now()->locale('es')->translatedFormat('F \d\e Y')) }}</p>
        </div>
        <div class="clearfix"></div>
    </div>

    <table >
        <thead>
            <tr>
                <th class="text-left">Modelo del Equipo</th>
                <th class="text-right">Fecha Entrega</th>
                <th class="text-right">Costo Servicio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->modelo }}</td>
                    <td class="text-right">{{ $equipo->fecha_entrega ? $equipo->fecha_entrega->format('d/m/Y') : 'N/A' }}</td>
                    <td class="text-right font-black text-navy">${{ number_format($equipo->costo, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Sin movimientos este mes.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 25px; background: #1e3d6c; color: white; padding: 15px; border-radius: 8px; text-align: right;">
        <span style="font-size: 11px; opacity: 0.8;" class="uppercase font-black">Total Facturado:</span>
        <span style="font-size: 18px; display: block;" class="font-black">${{ number_format($equipos->sum('costo'), 2) }}</span>
    </div>

    <div class="footer-pdf">
        Documento Oficial Zenith System • Emitido el {{ now()->format('d/m/Y H:i') }}
    </div>
</div>
@endsection